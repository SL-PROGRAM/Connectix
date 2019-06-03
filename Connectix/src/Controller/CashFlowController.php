<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Socity;
use App\Repository\BalanceSheetRepository;
use App\Repository\LoanRepository;
use App\Repository\ProductionOrderRepository;
use App\Repository\PurchaseOrderRepository;
use App\Repository\SalesOrderRepository;
use App\Service\BalanceSheetCall;
use App\Service\BalanceSheetRecord;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CashFlowController
 * @package App\Controller
 */
class CashFlowController extends AbstractController
{
    /**
     * @Route("/cashflow", name="cash_flow")
     * @param ProductionOrderRepository $productionOrderRepository
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRecord $balanceSheetRecord
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param SalesOrderRepository $salesOrderRepository
     * @param LoanRepository $loanRepository
     * @param PurchaseOrderRepository $purchaseOrderRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ProductionOrderRepository $productionOrderRepository,
                          BalanceSheetCall $balanceSheetCall,
                          BalanceSheetRecord $balanceSheetRecord,
                          BalanceSheetRepository $balanceSheetRepository,
                          SalesOrderRepository $salesOrderRepository,
                          LoanRepository $loanRepository,
                          PurchaseOrderRepository $purchaseOrderRepository)
    {
        $game = $this->getUser()->getGame();
        $socity = $this->getUser()->getSocity();
        $turn = $game->getTurn();
        $tva = $game->getTva() / 100;

        //FOR CALCULATION
        $monthlyRowMaterialHTPurchase = $this->monthlyRowMaterialHTPurchase($socity, $turn, $productionOrderRepository);
        $monthlyMerchandiseHTPurchase = $this->monthlyMerchandiseHTPurchase($socity, $turn, $purchaseOrderRepository);
        $personnelCostBrut = $this->personnelCostBrut($socity, $turn, $balanceSheetCall, $balanceSheetRepository);
        $monthlyMerchandiseHTSales = $this->monthlyMerchandiseHTSales($socity, $turn, $salesOrderRepository);


        //CASH INCLUDES TTC
        $cashingSales = $this->cashingSales($monthlyMerchandiseHTSales, $balanceSheetRepository, $balanceSheetRecord, $balanceSheetCall, $socity, $turn, $tva);
        $capitalContribution = $this->capitalContribution($socity, $turn, $balanceSheetCall, $balanceSheetRepository);
        $mediumAndLongLoan = $this->mediumAndLongLoan($socity, $turn, $balanceSheetCall, $balanceSheetRepository);
        $creditTVA = $this->creditTVA();
        $transferOfCapital = $this->transfertOfCapital();


        //DISBURSEMENTS TTC


        $monthlyRowMaterialTTCPurchase = $this->monthlyRowMaterialTTCPurchase($socity, $turn, $balanceSheetRecord, $balanceSheetCall, $balanceSheetRepository, $monthlyRowMaterialHTPurchase, $tva);
        $monthlyMerchandiseTTCPurchase = $this->monthlyMerchandiseTTCPurchase($socity, $turn, $balanceSheetRecord, $balanceSheetCall, $balanceSheetRepository, $monthlyMerchandiseHTPurchase, $tva);
        $externalCharges = $this->externalCharges($socity, $turn, $balanceSheetCall, $balanceSheetRepository);
        $personnelCostNet = $this->personnelCostNet($personnelCostBrut, $game);
        $socialTaxes = $this->socialTaxes($personnelCostBrut, $game,$balanceSheetRecord, $balanceSheetCall, $turn);
        $dueAndTaxes = $this->dueAndTaxes($monthlyMerchandiseHTSales, $personnelCostBrut, $game);
        $financialExpenses = $this->financialExpenses($socity, $turn, $balanceSheetCall, $balanceSheetRepository);
        $dueTVA = $this->dueTVA();
        $tangibleInvestments = $this->tangibleInvestments($socity, $turn, $balanceSheetCall, $balanceSheetRepository, $tva);
        $repaymentOfLoan = $this->repaymentOfLoan($socity, $loanRepository);

        //VAT CALCULATION


        $monthlyCollectedTVA = $this->collectedTVA($monthlyMerchandiseHTSales, $tva);
        $monthlyDedectibleTVA = $this->deductedTVA($monthlyRowMaterialHTPurchase, $monthlyMerchandiseHTPurchase, $externalCharges, $tangibleInvestments, $tva);


        $this->TvaRepartition($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, $balanceSheetCall, $balanceSheetRecord);


        //TOTAL
        $totalCashing = $this->totalCaching($cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital);
        $totalDisturb = $this->totalDisturb($monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan);
        $totalMonth = $this->totalMonth($totalCashing, $totalDisturb);
        $totalEndMonth = $this->totalEndMonth($totalMonth, $balanceSheetCall, $balanceSheetRecord, $turn);


        return $this->render('cash_flow/index.html.twig', [
            'controller_name' => 'CashFlowController',
            'cashingSales' => $cashingSales,
            'capitalContribution' => $capitalContribution,
            'mediumAndLongLoan' => $mediumAndLongLoan,
            'creditTVA' => $creditTVA,
            'transferOfCapital' => $transferOfCapital,
            'monthlyRowMaterialTTCPurchase' => $monthlyRowMaterialTTCPurchase,
            'monthlyMerchandiseTTCPurchase' => $monthlyMerchandiseTTCPurchase,
            'externalCharges' => $externalCharges,
            'dueAndTaxes' => $dueAndTaxes,
            'personnelCostNet' => $personnelCostNet,
            'socialTaxes' => $socialTaxes,
            'financialExpenses' => $financialExpenses,
            'dueTVA' => $dueTVA,
            'tangibleInvestments' => $tangibleInvestments,
            'repaymentOfLoan' => $repaymentOfLoan,
            'totalDisturb' => $totalDisturb,
            'totalCashing' => $totalCashing,
            'totalMonth' => $totalMonth,
            'totalEndMonth' => $totalEndMonth,
        ]);
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param ProductionOrderRepository $repository
     * @return array
     */
    private function monthlyRowMaterialHTPurchase(Socity $socity, $turn, ProductionOrderRepository $repository)
    {
        $monthlyProductionCost = [
            'january' => 0,
            'february' => 0,
            'march' => 0,
            'april' => 0,
            'may' => 0,
            'june' => 0,
            'july' => 0,
            'august' => 0,
            'september' => 0,
            'october' => 0,
            'november' => 0,
            'december' => 0,
        ];
        $productionOrders = $repository->findBy([
            'socity' => $socity,
            'turn' => $turn,
        ]);
        foreach ($productionOrders as $productionOrder) {
            $product = $productionOrder->getProduct();
            $monthlyAvgProductionCost = $productionOrder->getRowMaterialCost() / 12;

            $monthlyProductionCost['january'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getJanuary(), 2);
            $monthlyProductionCost['february'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getFebruary(), 2);
            $monthlyProductionCost['march'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getMarch(), 2);
            $monthlyProductionCost['april'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getApril(), 2);
            $monthlyProductionCost['may'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getMay(), 2);
            $monthlyProductionCost['june'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getJune(), 2);
            $monthlyProductionCost['july'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getJuly(), 2);
            $monthlyProductionCost['august'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getAugust(), 2);
            $monthlyProductionCost['september'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getSeptember(), 2);
            $monthlyProductionCost['october'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getOctober(), 2);
            $monthlyProductionCost['november'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getNovember(), 2);
            $monthlyProductionCost['december'] += round($monthlyAvgProductionCost * $product->getSeasonality()->getDecember(), 2);
        }
        return $monthlyProductionCost;
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param PurchaseOrderRepository $repository
     * @return array
     */
    private function monthlyMerchandiseHTPurchase(Socity $socity, $turn, PurchaseOrderRepository $repository)
    {
        $monthlyMerchandiseHTPurchase = [
            'january' => 0,
            'february' => 0,
            'march' => 0,
            'april' => 0,
            'may' => 0,
            'june' => 0,
            'july' => 0,
            'august' => 0,
            'september' => 0,
            'october' => 0,
            'november' => 0,
            'december' => 0,
        ];

        $orders = $repository->findBy([
            'socity' => $socity,
            'turn' => $turn,
        ]);

        foreach ($orders as $order) {
            $product = $order->getProduct();
            $monthlyAvgCost = ($order->getProductQuantityPurchase() * $order->getPurchasePrice() / 12);

            $monthlyMerchandiseHTPurchase['january'] += round($monthlyAvgCost * $product->getSeasonality()->getJanuary(), 2);
            $monthlyMerchandiseHTPurchase['february'] += round($monthlyAvgCost * $product->getSeasonality()->getFebruary(), 2);
            $monthlyMerchandiseHTPurchase['march'] += round($monthlyAvgCost * $product->getSeasonality()->getMarch(), 2);
            $monthlyMerchandiseHTPurchase['april'] += round($monthlyAvgCost * $product->getSeasonality()->getApril(), 2);
            $monthlyMerchandiseHTPurchase['may'] += round($monthlyAvgCost * $product->getSeasonality()->getMay(), 2);
            $monthlyMerchandiseHTPurchase['june'] += round($monthlyAvgCost * $product->getSeasonality()->getJune(), 2);
            $monthlyMerchandiseHTPurchase['july'] += round($monthlyAvgCost * $product->getSeasonality()->getJuly(), 2);
            $monthlyMerchandiseHTPurchase['august'] += round($monthlyAvgCost * $product->getSeasonality()->getAugust(), 2);
            $monthlyMerchandiseHTPurchase['september'] += round($monthlyAvgCost * $product->getSeasonality()->getSeptember(), 2);
            $monthlyMerchandiseHTPurchase['october'] += round($monthlyAvgCost * $product->getSeasonality()->getOctober(), 2);
            $monthlyMerchandiseHTPurchase['november'] += round($monthlyAvgCost * $product->getSeasonality()->getNovember(), 2);
            $monthlyMerchandiseHTPurchase['december'] += round($monthlyAvgCost * $product->getSeasonality()->getDecember(), 2);
        }
        return $monthlyMerchandiseHTPurchase;
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param SalesOrderRepository $repository
     * @return array
     */
    private function monthlyMerchandiseHTSales(Socity $socity, $turn, SalesOrderRepository $repository)
    {
        $monthlyMerchandiseHTSales = [
            'january' => 0,
            'february' => 0,
            'march' => 0,
            'april' => 0,
            'may' => 0,
            'june' => 0,
            'july' => 0,
            'august' => 0,
            'september' => 0,
            'october' => 0,
            'november' => 0,
            'december' => 0,
        ];


        $orders = $repository->findBy([
            'socity' => $socity,
            'turn' => $turn,
        ]);
        foreach ($orders as $order) {
            $product = $order->getProduct();
            $monthlyAvgCost = ($order->getProductQuantitySales() * $order->getSalesPrice() / 12);

            $monthlyMerchandiseHTSales['january'] += round($monthlyAvgCost * $product->getSeasonality()->getJanuary(), 2);
            $monthlyMerchandiseHTSales['february'] += round($monthlyAvgCost * $product->getSeasonality()->getFebruary(), 2);
            $monthlyMerchandiseHTSales['march'] += round($monthlyAvgCost * $product->getSeasonality()->getMarch(), 2);
            $monthlyMerchandiseHTSales['april'] += round($monthlyAvgCost * $product->getSeasonality()->getApril(), 2);
            $monthlyMerchandiseHTSales['may'] += round($monthlyAvgCost * $product->getSeasonality()->getMay(), 2);
            $monthlyMerchandiseHTSales['june'] += round($monthlyAvgCost * $product->getSeasonality()->getJune(), 2);
            $monthlyMerchandiseHTSales['july'] += round($monthlyAvgCost * $product->getSeasonality()->getJuly(), 2);
            $monthlyMerchandiseHTSales['august'] += round($monthlyAvgCost * $product->getSeasonality()->getAugust(), 2);
            $monthlyMerchandiseHTSales['september'] += round($monthlyAvgCost * $product->getSeasonality()->getSeptember(), 2);
            $monthlyMerchandiseHTSales['october'] += round($monthlyAvgCost * $product->getSeasonality()->getOctober(), 2);
            $monthlyMerchandiseHTSales['november'] += round($monthlyAvgCost * $product->getSeasonality()->getNovember(), 2);
            $monthlyMerchandiseHTSales['december'] += round($monthlyAvgCost * $product->getSeasonality()->getDecember(), 2);
        }
        return $monthlyMerchandiseHTSales;
    }

    /*
     * DISBURSEMENTS
     */
    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetRecord $balanceSheetRecord
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param $monthlyRowMaterialHTPurchase
     * @param $tva
     * @return array
     */
    private function monthlyRowMaterialTTCPurchase(Socity $socity, $turn, BalanceSheetRecord $balanceSheetRecord, BalanceSheetCall $balanceSheetCall, BalanceSheetRepository $balanceSheetRepository, $monthlyRowMaterialHTPurchase, $tva)
    {

        $balanceSheetRecord->rowMaterial30j($socity, $turn, $balanceSheetRepository, round($monthlyRowMaterialHTPurchase['november'] * $tva, 2));
        $balanceSheetRecord->rowMaterial60j($socity, $turn, $balanceSheetRepository, round($monthlyRowMaterialHTPurchase['december'] * $tva, 2));

        return $monthlyRowMaterialTTCPurchase = [
            'january' => $balanceSheetCall->rowMaterial30j($socity, $turn-1, $balanceSheetRepository),
            'february' => $balanceSheetCall->rowMaterial60j($socity, $turn-1, $balanceSheetRepository),
            'march' => round($monthlyRowMaterialHTPurchase['january'] * $tva, 2),
            'april' => round($monthlyRowMaterialHTPurchase['february'] * $tva, 2),
            'may' => round($monthlyRowMaterialHTPurchase['march'] * $tva, 2),
            'june' => round($monthlyRowMaterialHTPurchase['april'] * $tva, 2),
            'july' => round($monthlyRowMaterialHTPurchase['may'] * $tva, 2),
            'august' => round($monthlyRowMaterialHTPurchase['june'] * $tva, 2),
            'september' => round($monthlyRowMaterialHTPurchase['july'] * $tva, 2),
            'october' => round($monthlyRowMaterialHTPurchase['august'] * $tva, 2),
            'november' => round($monthlyRowMaterialHTPurchase['september'] * $tva, 2),
            'december' => round($monthlyRowMaterialHTPurchase['october'] * $tva, 2),
        ];


    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetRecord $balanceSheetRecord
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param $monthlyMerchandiseHTPurchase
     * @param $tva
     * @return array
     */
    private function monthlyMerchandiseTTCPurchase(Socity $socity, $turn, BalanceSheetRecord $balanceSheetRecord, BalanceSheetCall $balanceSheetCall, BalanceSheetRepository $balanceSheetRepository, $monthlyMerchandiseHTPurchase, $tva)
    {

        //Save value of merchandise without TVA
        $balanceSheetRecord->merchandisePurchase30j($socity, $turn, $balanceSheetRepository, round($monthlyMerchandiseHTPurchase['december'], 2));


        return $monthlyMerchandiseTTCPurchase = [
            'january' => $balanceSheetCall->merchandisePurchase30j($socity, $turn-1, $balanceSheetRepository)* (1 + $tva),
            'february' => round($monthlyMerchandiseHTPurchase['january'] * (1+ $tva), 2),
            'march' => round($monthlyMerchandiseHTPurchase['february'] * (1+ $tva), 2),
            'april' => round($monthlyMerchandiseHTPurchase['march'] * (1+ $tva), 2),
            'may' => round($monthlyMerchandiseHTPurchase['april'] * (1+ $tva), 2),
            'june' => round($monthlyMerchandiseHTPurchase['may'] * (1+ $tva), 2),
            'july' => round($monthlyMerchandiseHTPurchase['june'] * (1+ $tva), 2),
            'august' => round($monthlyMerchandiseHTPurchase['july'] * (1+ $tva), 2),
            'september' => round($monthlyMerchandiseHTPurchase['august'] * (1+ $tva), 2),
            'october' => round($monthlyMerchandiseHTPurchase['september'] * (1+ $tva), 2),
            'november' => round($monthlyMerchandiseHTPurchase['october'] * (1+ $tva), 2),
            'december' => round($monthlyMerchandiseHTPurchase['november'] * (1+ $tva), 2),
        ];
    }

    /**
     * @param $socity
     * @param $turn
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRepository $balanceSheetRepository
     * @return array
     */
    private function externalCharges($socity, $turn, BalanceSheetCall $balanceSheetCall, BalanceSheetRepository $balanceSheetRepository)
    {
        $monthlyOtherCharge = round($balanceSheetCall->otherPurchaseAndExternalCharges($socity, $turn, $balanceSheetRepository)
            / 12, 2);

        return $externalCharges = [
            'january' => $monthlyOtherCharge,
            'february' => $monthlyOtherCharge,
            'march' => $monthlyOtherCharge,
            'april' => $monthlyOtherCharge,
            'may' => $monthlyOtherCharge,
            'june' => $monthlyOtherCharge,
            'july' => $monthlyOtherCharge,
            'august' => $monthlyOtherCharge,
            'september' => $monthlyOtherCharge,
            'october' => $monthlyOtherCharge,
            'november' => $monthlyOtherCharge,
            'december' => $monthlyOtherCharge,
        ];
    }

    /**
     * @param $socity
     * @param $turn
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRepository $balanceSheetRepository
     * @return array
     */
    private function personnelCostBrut($socity, $turn, BalanceSheetCall $balanceSheetCall, BalanceSheetRepository $balanceSheetRepository)
    {
        $personnelCost = round($balanceSheetCall->payRoll($socity, $turn, $balanceSheetRepository)
            / 12, 2);

        return $personnelCostBrut = [
            'january' => $personnelCost,
            'february' => $personnelCost,
            'march' => $personnelCost,
            'april' => $personnelCost,
            'may' => $personnelCost,
            'june' => $personnelCost,
            'july' => $personnelCost,
            'august' => $personnelCost,
            'september' => $personnelCost,
            'october' => $personnelCost,
            'november' => $personnelCost,
            'december' => $personnelCost,
        ];
    }

    /**
     * @param $monthlyMerchandiseHTSales
     * @param $personnelCostBrut
     * @param Game $game
     * @return array
     */
    private function dueAndTaxes($monthlyMerchandiseHTSales, $personnelCostBrut, Game $game)
    {
        $payTax = $game->getPayTax() / 100;
        $taxTurnover = $game->getTaxTurnover() / 100;
        $tva = $game->getTva()/100;

        return $dueAndTaxes = [
            'january' => round(($monthlyMerchandiseHTSales['january'] * $payTax)*(1+$tva), 2) +
                round($personnelCostBrut['january'] * $taxTurnover, 2),
            'february' => round($monthlyMerchandiseHTSales['february'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['february'] * $taxTurnover, 2),
            'march' => round($monthlyMerchandiseHTSales['march'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['march'] * $taxTurnover, 2),
            'april' => round($monthlyMerchandiseHTSales['april'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['april'] * $taxTurnover, 2),
            'may' => round($monthlyMerchandiseHTSales['may'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['may'] * $taxTurnover, 2),
            'june' => round($monthlyMerchandiseHTSales['june'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['june'] * $taxTurnover, 2),
            'july' => round($monthlyMerchandiseHTSales['july'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['july'] * $taxTurnover, 2),
            'august' => round($monthlyMerchandiseHTSales['august'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['august'] * $taxTurnover, 2),
            'september' => round($monthlyMerchandiseHTSales['september'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['september'] * $taxTurnover, 2),
            'october' => round($monthlyMerchandiseHTSales['october'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['october'] * $taxTurnover, 2),
            'november' => round($monthlyMerchandiseHTSales['november'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['november'] * $taxTurnover, 2),
            'december' => round($monthlyMerchandiseHTSales['december'] * $payTax*(1+$tva), 2) +
                round($personnelCostBrut['december'] * $taxTurnover, 2),
        ];
    }

    /**
     * @param $personnelCostBrut
     * @param Game $game
     * @return array
     */
    private function personnelCostNet($personnelCostBrut, Game $game)
    {
        $salaryContributions = $game->getSalaryContributions() / 100;

        return $personnelCostNet = [
            'january' => round($personnelCostBrut['january'] * (1 - $salaryContributions), 2),
            'february' => round($personnelCostBrut['february'] * (1 - $salaryContributions), 2),
            'march' => round($personnelCostBrut['march'] * (1 - $salaryContributions), 2),
            'april' => round($personnelCostBrut['april'] * (1 - $salaryContributions), 2),
            'may' => round($personnelCostBrut['may'] * (1 - $salaryContributions), 2),
            'june' => round($personnelCostBrut['june'] * (1 - $salaryContributions), 2),
            'july' => round($personnelCostBrut['july'] * (1 - $salaryContributions), 2),
            'august' => round($personnelCostBrut['august'] * (1 - $salaryContributions), 2),
            'september' => round($personnelCostBrut['september'] * (1 - $salaryContributions), 2),
            'october' => round($personnelCostBrut['october'] * (1 - $salaryContributions), 2),
            'november' => round($personnelCostBrut['november'] * (1 - $salaryContributions), 2),
            'december' => round($personnelCostBrut['december'] * (1 - $salaryContributions), 2),
        ];
    }

    /**
     * @param $personnelCostBrut
     * @param Game $game
     * @param BalanceSheetRecord $balanceSheetRecord
     * @param BalanceSheetCall $balanceSheetCall
     * @param $turn
     * @return array
     */
    private function socialTaxes($personnelCostBrut, Game $game, BalanceSheetRecord $balanceSheetRecord, BalanceSheetCall $balanceSheetCall, $turn)
    {
        $salaryContributions = $game->getSalaryContributions() / 100;
        $employerContributions = $game->getEmployerContributions() / 100;

        $balanceSheetRecord->taxAndSocialDebts(round($personnelCostBrut['december'] * ($employerContributions + $salaryContributions), 2));


        return $socialTaxes = [
            'january' => $balanceSheetCall->taxAndSocialDebts($turn-1),
            'february' => round($personnelCostBrut['january'] * ($employerContributions + $salaryContributions), 2),
            'march' => round($personnelCostBrut['february'] * ($employerContributions + $salaryContributions), 2),
            'april' => round($personnelCostBrut['march'] * ($employerContributions + $salaryContributions), 2),
            'may' => round($personnelCostBrut['april'] * ($employerContributions + $salaryContributions), 2),
            'june' => round($personnelCostBrut['may'] * ($employerContributions + $salaryContributions), 2),
            'july' => round($personnelCostBrut['june'] * ($employerContributions + $salaryContributions), 2),
            'august' => round($personnelCostBrut['july'] * ($employerContributions + $salaryContributions), 2),
            'september' => round($personnelCostBrut['august'] * ($employerContributions + $salaryContributions), 2),
            'october' => round($personnelCostBrut['september'] * ($employerContributions + $salaryContributions), 2),
            'november' => round($personnelCostBrut['october'] * ($employerContributions + $salaryContributions), 2),
            'december' => round($personnelCostBrut['november'] * ($employerContributions + $salaryContributions), 2),
        ];
    }

    /**
     * @param $socity
     * @param $turn
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRepository $balanceSheetRepository
     * @return array
     */
    private function financialExpenses($socity, $turn, BalanceSheetCall $balanceSheetCall, BalanceSheetRepository $balanceSheetRepository)
    {
        $interest = $balanceSheetCall->interestAndSimilarExpenses($socity, $turn, $balanceSheetRepository);
        return $financialExpenses = [
            'january' => 0,
            'february' => 0,
            'march' => 0,
            'april' => 0,
            'may' => 0,
            'june' => 0,
            'july' => 0,
            'august' => 0,
            'september' => 0,
            'october' => 0,
            'november' => 0,
            'december' => $interest,
        ];
    }

    /**
     * @return array
     */
    private function dueTVA()
    {
        return $dueTVA = [
            'january' => 0,
            'february' => 0,
            'march' => 0,
            'april' => 0,
            'may' => 0,
            'june' => 0,
            'july' => 0,
            'august' => 0,
            'september' => 0,
            'october' => 0,
            'november' => 0,
            'december' => 0,
        ];

    }

    /**
     * @param $socity
     * @param $turn
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param $tva
     * @return array
     */
    private function tangibleInvestments($socity, $turn, BalanceSheetCall $balanceSheetCall, BalanceSheetRepository $balanceSheetRepository, $tva)
    {
        $groundLastTurn = $balanceSheetCall->grounds($socity, $turn - 1, $balanceSheetRepository);
        $productionLignLastTurn = $balanceSheetCall->productionLign($socity, $turn - 1, $balanceSheetRepository);
        $factoyLastTurn = $balanceSheetCall->factory($socity, $turn - 1, $balanceSheetRepository);
        $groundTurn = $balanceSheetCall->grounds($socity, $turn, $balanceSheetRepository);
        $productionLignTurn = $balanceSheetCall->productionLign($socity, $turn, $balanceSheetRepository);
        $factoyTurn = $balanceSheetCall->factory($socity, $turn, $balanceSheetRepository);

        return $cashingSales = [
            'january' => ($groundTurn - $groundLastTurn +
                    $factoyTurn - $factoyLastTurn +
                    $productionLignTurn - $productionLignLastTurn) * (1 + $tva),
            'february' => 0,
            'march' => 0,
            'april' => 0,
            'may' => 0,
            'june' => 0,
            'july' => 0,
            'august' => 0,
            'september' => 0,
            'october' => 0,
            'november' => 0,
            'december' => 0,
        ];


    }

    /**
     * @param $socity
     * @param LoanRepository $loanRepository
     * @return array
     */
    private function repaymentOfLoan($socity, LoanRepository $loanRepository)
    {
        $annualRepayement = 0;
        $loans = $loanRepository->findBy(['socity' => $socity]);
        foreach ($loans as $loan) {
            $annualRepayement += $loan->getBorrowAmount() / $loan->getLoanDuration();
        }

        $monthlyRepayement = round($annualRepayement / 12, 2);
        return $repaymentOfLoan = [
            'january' => $monthlyRepayement,
            'february' => $monthlyRepayement,
            'march' => $monthlyRepayement,
            'april' => $monthlyRepayement,
            'may' => $monthlyRepayement,
            'june' => $monthlyRepayement,
            'july' => $monthlyRepayement,
            'august' => $monthlyRepayement,
            'september' => $monthlyRepayement,
            'october' => $monthlyRepayement,
            'november' => $monthlyRepayement,
            'december' => $monthlyRepayement,
        ];
    }

    /*
     * CASH INCLUDES
     */
    /**
     * @param $monthlyMerchandiseHTSales
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param BalanceSheetRecord $balanceSheetRecord
     * @param BalanceSheetCall $balanceSheetCall
     * @param Socity $socity
     * @param $turn
     * @return array
     */
    private function cashingSales($monthlyMerchandiseHTSales, BalanceSheetRepository $balanceSheetRepository, BalanceSheetRecord $balanceSheetRecord, BalanceSheetCall $balanceSheetCall, Socity $socity, $turn, $tva)
    {
        $balanceSheet = $balanceSheetRepository->findOneBy(['socity' => $socity, 'turn' => $turn]);
        $customer0j = $balanceSheet->getCustomer0j() / 100;
        $customer30j = $balanceSheet->getCustomer30j() / 100;
        $customer60j = $balanceSheet->getCustomer60j() / 100;

        $cashingSales0j = [
            'january' => $monthlyMerchandiseHTSales['january'] * $customer0j,
            'february' => $monthlyMerchandiseHTSales['february'] * $customer0j,
            'march' => $monthlyMerchandiseHTSales['march'] * $customer0j,
            'april' => $monthlyMerchandiseHTSales['april'] * $customer0j,
            'may' => $monthlyMerchandiseHTSales['may'] * $customer0j,
            'june' => $monthlyMerchandiseHTSales['june'] * $customer0j,
            'july' => $monthlyMerchandiseHTSales['july'] * $customer0j,
            'august' => $monthlyMerchandiseHTSales['august'] * $customer0j,
            'september' => $monthlyMerchandiseHTSales['september'] * $customer0j,
            'october' => $monthlyMerchandiseHTSales['october'] * $customer0j,
            'november' => $monthlyMerchandiseHTSales['november'] * $customer0j,
            'december' => $monthlyMerchandiseHTSales['december'] * $customer0j,
        ];

        $cashingSales30j = [
            'january' => $balanceSheetCall->salesCashing30j($socity, $turn-1, $balanceSheetRepository),
            'february' => $monthlyMerchandiseHTSales['january'] * $customer30j,
            'march' => $monthlyMerchandiseHTSales['february'] * $customer30j,
            'april' => $monthlyMerchandiseHTSales['march'] * $customer30j,
            'may' => $monthlyMerchandiseHTSales['april'] * $customer30j,
            'june' => $monthlyMerchandiseHTSales['may'] * $customer30j,
            'july' => $monthlyMerchandiseHTSales['june'] * $customer30j,
            'august' => $monthlyMerchandiseHTSales['july'] * $customer30j,
            'september' => $monthlyMerchandiseHTSales['august'] * $customer30j,
            'october' => $monthlyMerchandiseHTSales['september'] * $customer30j,
            'november' => $monthlyMerchandiseHTSales['october'] * $customer30j,
            'december' => $monthlyMerchandiseHTSales['november'] * $customer30j,
        ];

        $cashingSales60j = [
            'january' => 0,
            'february' => $balanceSheetCall->salesCashing60j($socity, $turn-1, $balanceSheetRepository),
            'march' => $monthlyMerchandiseHTSales['january'] * $customer60j,
            'april' => $monthlyMerchandiseHTSales['february'] * $customer60j,
            'may' => $monthlyMerchandiseHTSales['march'] * $customer60j,
            'june' => $monthlyMerchandiseHTSales['april'] * $customer60j,
            'july' => $monthlyMerchandiseHTSales['may'] * $customer60j,
            'august' => $monthlyMerchandiseHTSales['june'] * $customer60j,
            'september' => $monthlyMerchandiseHTSales['july'] * $customer60j,
            'october' => $monthlyMerchandiseHTSales['august'] * $customer60j,
            'november' => $monthlyMerchandiseHTSales['september'] * $customer60j,
            'december' => $monthlyMerchandiseHTSales['october'] * $customer60j,
        ];


        $balanceSheetRecord->salesCashing30j($socity, $turn, $balanceSheetRepository, ($monthlyMerchandiseHTSales['december'] * $customer30j + $monthlyMerchandiseHTSales['november'] * $customer60j));
        $balanceSheetRecord->salesCashing60j($socity, $turn, $balanceSheetRepository, ($monthlyMerchandiseHTSales['december'] * $customer60j));

        $cashingSales = [
            'january' => round(($cashingSales0j['january'] + $cashingSales30j['january'] + $cashingSales60j['january']) *(1 + $tva),2),
            'february' => round(($cashingSales0j['february'] + $cashingSales30j['february'] + $cashingSales60j['february'] )*(1 + $tva),2),
            'march' => round(($cashingSales0j['march'] + $cashingSales30j['march'] + $cashingSales60j['march']) *(1 + $tva), 2),
            'april' => round(($cashingSales0j['april'] + $cashingSales30j['april'] + $cashingSales60j['april'])*(1 + $tva), 2) ,
            'may' => round(($cashingSales0j['may'] + $cashingSales30j['may'] + $cashingSales60j['may'])*(1 + $tva), 2) ,
            'june' => round(($cashingSales0j['june'] + $cashingSales30j['june'] + $cashingSales60j['june'])*(1 + $tva), 2),
            'july' => round(($cashingSales0j['july'] + $cashingSales30j['july'] + $cashingSales60j['july'])*(1 + $tva), 2),
            'august' => round(($cashingSales0j['august'] + $cashingSales30j['august'] + $cashingSales60j['august'])*(1 + $tva), 2),
            'september' => round(($cashingSales0j['september'] + $cashingSales30j['september'] + $cashingSales60j['september'])*(1 + $tva), 2),
            'october' => round(($cashingSales0j['october'] + $cashingSales30j['october'] + $cashingSales60j['october'])*(1 + $tva), 2),
            'november' => round(($cashingSales0j['november'] + $cashingSales30j['november'] + $cashingSales60j['november'])*(1 + $tva), 2),
            'december' => round(($cashingSales0j['december'] + $cashingSales30j['december'] + $cashingSales60j['december'])*(1 + $tva), 2),
        ];

        return $cashingSales;
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRepository $balanceSheetRepository
     * @return array
     */
    private function capitalContribution(Socity $socity, $turn, BalanceSheetCall $balanceSheetCall, BalanceSheetRepository $balanceSheetRepository)
    {
        $shareCapitalOrIndividuallastTurn = $balanceSheetCall->shareCapitalOrIndividual($socity, $turn - 1, $balanceSheetRepository);
        $shareCapitalOrIndividualTurn = $balanceSheetCall->shareCapitalOrIndividual($socity, $turn, $balanceSheetRepository);

        $upShareCapitalOrIndividual = $shareCapitalOrIndividualTurn - $shareCapitalOrIndividuallastTurn;
        if ($upShareCapitalOrIndividual < 0) {
            $upShareCapitalOrIndividual = 0;
        }
        return $capitalContribution = [
            'january' => $upShareCapitalOrIndividual,
            'february' => 0,
            'march' => 0,
            'april' => 0,
            'may' => 0,
            'june' => 0,
            'july' => 0,
            'august' => 0,
            'september' => 0,
            'october' => 0,
            'november' => 0,
            'december' => 0,
        ];
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRepository $balanceSheetRepository
     * @return array
     */
    private function mediumAndLongLoan(Socity $socity, $turn, BalanceSheetCall $balanceSheetCall, BalanceSheetRepository $balanceSheetRepository)
    {
        $mediumAndLongLoanLastTurn = $balanceSheetCall->loanAndDebtsWihCreditInstitutions($socity, $turn - 1, $balanceSheetRepository);
        $mediumAndLongLoanTurn = $balanceSheetCall->loanAndDebtsWihCreditInstitutions($socity, $turn, $balanceSheetRepository);

        $upLoan = $mediumAndLongLoanTurn - $mediumAndLongLoanLastTurn;
        if ($upLoan < 0) {
            $upLoan = 0;
        }
        return $mediumAndLongLoan = [
            'january' => $upLoan,
            'february' => 0,
            'march' => 0,
            'april' => 0,
            'may' => 0,
            'june' => 0,
            'july' => 0,
            'august' => 0,
            'september' => 0,
            'october' => 0,
            'november' => 0,
            'december' => 0,
        ];
    }

    /**
     * @return array
     */
    private function creditTVA()
    {
        return $creditTVA = [
            'january' => 0,
            'february' => 0,
            'march' => 0,
            'april' => 0,
            'may' => 0,
            'june' => 0,
            'july' => 0,
            'august' => 0,
            'september' => 0,
            'october' => 0,
            'november' => 0,
            'december' => 0,
        ];
    }

    /**
     * @return array
     */
    private function transfertOfCapital()
    {
        return $transfertOfCapital = [
            'january' => 0,
            'february' => 0,
            'march' => 0,
            'april' => 0,
            'may' => 0,
            'june' => 0,
            'july' => 0,
            'august' => 0,
            'september' => 0,
            'october' => 0,
            'november' => 0,
            'december' => 0,
        ];
    }


    /*
     * VAT CALCULATION
     */
    /**
     * @param $monthlyMerchandiseHTSales
     * @param $tva
     * @return array
     */
    private function collectedTVA($monthlyMerchandiseHTSales, $tva)
    {
        return $monthlyCollectedTVA = [
            'january' => $monthlyMerchandiseHTSales['january'] * $tva,
            'february' => $monthlyMerchandiseHTSales['february'] * $tva,
            'march' => $monthlyMerchandiseHTSales['march'] * $tva,
            'april' => $monthlyMerchandiseHTSales['april'] * $tva,
            'may' => $monthlyMerchandiseHTSales['may'] * $tva,
            'june' => $monthlyMerchandiseHTSales['june'] * $tva,
            'july' => $monthlyMerchandiseHTSales['july'] * $tva,
            'august' => $monthlyMerchandiseHTSales['august'] * $tva,
            'september' => $monthlyMerchandiseHTSales['september'] * $tva,
            'october' => $monthlyMerchandiseHTSales['october'] * $tva,
            'november' => $monthlyMerchandiseHTSales['november'] * $tva,
            'december' => $monthlyMerchandiseHTSales['december'] * $tva,
        ];


    }

    /**
     * @param $monthlyRowMaterialHTPurchase
     * @param $monthlyMerchandiseHTPurchase
     * @param $externalCharges
     * @param $tangibleInvestments
     * @param $tva
     * @return array
     */
    private function deductedTVA($monthlyRowMaterialHTPurchase, $monthlyMerchandiseHTPurchase, $externalCharges, $tangibleInvestments, $tva)
    {


        return $deductedTVA = [
            'january' => round(($monthlyRowMaterialHTPurchase['january'] + $monthlyMerchandiseHTPurchase['january'] +
                    $externalCharges['january'] + $tangibleInvestments['january'])
                * $tva , 2),
            'february' => round(($monthlyRowMaterialHTPurchase['february'] + $monthlyMerchandiseHTPurchase['february'] +
                    $externalCharges['february'] + $tangibleInvestments['february'])
                * $tva, 2),
            'march' => round(($monthlyRowMaterialHTPurchase['march'] + $monthlyMerchandiseHTPurchase['march'] +
                    $externalCharges['march'] + $tangibleInvestments['march'])
                * $tva, 2),
            'april' => round(($monthlyRowMaterialHTPurchase['april'] + $monthlyMerchandiseHTPurchase['april'] +
                    $externalCharges['april'] + $tangibleInvestments['april'])
                * $tva, 2),
            'may' => round(($monthlyRowMaterialHTPurchase['may'] + $monthlyMerchandiseHTPurchase['may'] +
                    $externalCharges['may'] + $tangibleInvestments['may'])
                * $tva, 2),
            'june' => round(($monthlyRowMaterialHTPurchase['june'] + $monthlyMerchandiseHTPurchase['june'] +
                    $externalCharges['june'] + $tangibleInvestments['june'])
                * $tva, 2),
            'july' => round(($monthlyRowMaterialHTPurchase['july'] + $monthlyMerchandiseHTPurchase['july'] +
                    $externalCharges['july'] + $tangibleInvestments['july'])
                * $tva, 2),
            'august' => round(($monthlyRowMaterialHTPurchase['august'] + $monthlyMerchandiseHTPurchase['august'] +
                    $externalCharges['august'] + $tangibleInvestments['august'])
                * $tva, 2),
            'september' => round(($monthlyRowMaterialHTPurchase['september'] + $monthlyMerchandiseHTPurchase['september'] +
                    $externalCharges['september'] + $tangibleInvestments['september'])
                * $tva, 2),
            'october' => round(($monthlyRowMaterialHTPurchase['october'] + $monthlyMerchandiseHTPurchase['october'] +
                    $externalCharges['october'] + $tangibleInvestments['october'])
                * $tva, 2),
            'november' => round(($monthlyRowMaterialHTPurchase['november'] + $monthlyMerchandiseHTPurchase['november'] +
                    $externalCharges['november'] + $tangibleInvestments['november'])
                * $tva, 2),
            'december' => round(($monthlyRowMaterialHTPurchase['december'] + $monthlyMerchandiseHTPurchase['december'] +
                    $externalCharges['december'] + $tangibleInvestments['december'])
                * $tva, 2),
        ];
    }

    /**
     * @param $dueTVA
     * @param $creditTVA
     * @param $monthlyCollectedTVA
     * @param $monthlyDedectibleTVA
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRecord $balanceSheetRecord
     */
    private function TvaRepartition(&$dueTVA, &$creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, BalanceSheetCall $balanceSheetCall, BalanceSheetRecord $balanceSheetRecord)
    {

        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'january', 'february', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'february', 'march', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'march', 'april', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'april', 'may', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'may', 'june', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'june', 'july', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'july', 'august', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'august', 'september', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'september', 'october', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'october', 'november', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'november', 'december', $balanceSheetCall, $balanceSheetRecord);
        $this->recordTVA($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, 'december', 'january1', $balanceSheetCall, $balanceSheetRecord);
    }

    /**
     * @param $dueTVA
     * @param $creditTVA
     * @param $monthlyCollectedTVA
     * @param $monthlyDedectibleTVA
     * @param $key
     * @param $nextMonth
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRecord $balanceSheetRecord
     */
    private function recordTVA(&$dueTVA, &$creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, $key, $nextMonth,
                               BalanceSheetCall $balanceSheetCall, BalanceSheetRecord $balanceSheetRecord)
    {
        $turn = $this->getUser()->getGame()->getTurn();
        if ($key === 'january') {
            $tva = round($balanceSheetCall->tva($turn-1) + $monthlyCollectedTVA[$key] - $monthlyDedectibleTVA[$key], 2);
            if ($tva > 0) {
                $dueTVA[$nextMonth] = $tva;
            } else {
                $creditTVA[$nextMonth] = -$tva;
            }
        }

        if ($key === 'december') {
            $tva = round($monthlyCollectedTVA[$key] - $monthlyDedectibleTVA[$key], 2);
            $balanceSheetRecord->tva($tva);
        }

        else {
            $tva = round($monthlyCollectedTVA[$key] - $monthlyDedectibleTVA[$key], 2);
            if ($tva > 0) {
                $dueTVA[$nextMonth] = $tva;
            } else {
                $creditTVA[$nextMonth] = -$tva;
            }
        }


    }

    /**
     * @param $cashingSales
     * @param $capitalContribution
     * @param $mediumAndLongLoan
     * @param $creditTVA
     * @param $transferOfCapital
     * @return array
     */
    private function totalCaching($cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital)
    {
        return $totalCaching = [
            'january' => $this->totalCashingCalculation('january', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'february' => $this->totalCashingCalculation('february', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'march' => $this->totalCashingCalculation('march', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'april' => $this->totalCashingCalculation('april', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'may' => $this->totalCashingCalculation('may', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'june' => $this->totalCashingCalculation('june', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'july' => $this->totalCashingCalculation('july', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'august' => $this->totalCashingCalculation('august', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'september' => $this->totalCashingCalculation('september', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'october' => $this->totalCashingCalculation('october', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'november' => $this->totalCashingCalculation('november', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital),
            'december' => $this->totalCashingCalculation('december', $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital)
        ];

    }

    /**
     * @param $key
     * @param $cashingSales
     * @param $capitalContribution
     * @param $mediumAndLongLoan
     * @param $creditTVA
     * @param $transferOfCapital
     * @return mixed
     */
    private function totalCashingCalculation($key, $cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital)
    {
        return $cashingSales[$key] +
            $capitalContribution[$key] +
            $mediumAndLongLoan[$key] +
            $creditTVA[$key] +
            $transferOfCapital[$key];


    }

    /**
     * @param $monthlyRowMaterialTTCPurchase
     * @param $monthlyMerchandiseTTCPurchase
     * @param $externalCharges
     * @param $personnelCostNet
     * @param $socialTaxes
     * @param $dueAndTaxes
     * @param $financialExpenses
     * @param $dueTVA
     * @param $tangibleInvestments
     * @param $repaymentOfLoan
     * @return array
     */
    private function totalDisturb($monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan)
    {
        return $totalDisturb = [
            'january' => $this->totalDisturbCalculation('january', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'february' => $this->totalDisturbCalculation('february', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'march' => $this->totalDisturbCalculation('march', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'april' => $this->totalDisturbCalculation('april', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'may' => $this->totalDisturbCalculation('may', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'june' => $this->totalDisturbCalculation('june', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'july' => $this->totalDisturbCalculation('july', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'august' => $this->totalDisturbCalculation('august', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'september' => $this->totalDisturbCalculation('september', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'october' => $this->totalDisturbCalculation('october', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'november' => $this->totalDisturbCalculation('november', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
            'december' => $this->totalDisturbCalculation('december', $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan),
        ];
    }

    /**
     * @param $key
     * @param $monthlyRowMaterialTTCPurchase
     * @param $monthlyMerchandiseTTCPurchase
     * @param $externalCharges
     * @param $personnelCostNet
     * @param $socialTaxes
     * @param $dueAndTaxes
     * @param $financialExpenses
     * @param $dueTVA
     * @param $tangibleInvestments
     * @param $repaymentOfLoan
     * @return mixed
     */
    private function totalDisturbCalculation($key, $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan)
    {
        return $monthlyRowMaterialTTCPurchase[$key] +
            $monthlyMerchandiseTTCPurchase[$key] +
            $externalCharges[$key] +
            $personnelCostNet[$key] +
            $socialTaxes[$key] +
            $dueAndTaxes[$key] +
            $financialExpenses[$key] +
            $dueTVA[$key] +
            $tangibleInvestments[$key] +
            $repaymentOfLoan[$key];


    }

    /**
     * @param $totalCashing
     * @param $totalDisturb
     * @return array
     */
    private function totalMonth($totalCashing, $totalDisturb)
    {
        return $totalMonth = [
            'january' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'january'),
            'february' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'february'),
            'march' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'march'),
            'april' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'april'),
            'may' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'may'),
            'june' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'june'),
            'july' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'july'),
            'august' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'august'),
            'september' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'september'),
            'october' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'october'),
            'november' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'november'),
            'december' => $this->totalMonthCalculation($totalCashing, $totalDisturb, 'december')
        ];
    }

    /**
     * @param $totalCashing
     * @param $totalDisturb
     * @param $keys
     * @return float
     */
    private function totalMonthCalculation($totalCashing, $totalDisturb, $keys)
    {
        return round($totalCashing[$keys] - $totalDisturb[$keys], 2);
    }

    /**
     * @param $totalMonth
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRecord $balanceSheetRecord
     * @param $turn
     * @return mixed
     */
    private function totalEndMonth($totalMonth, BalanceSheetCall $balanceSheetCall, BalanceSheetRecord $balanceSheetRecord, $turn)
    {

        $totalEndMonth['january'] = $balanceSheetCall->availability($turn - 1) + $totalMonth['january'];
        $totalEndMonth['february'] = $totalEndMonth['january'] + $totalMonth['february'];
        $totalEndMonth['march'] = $totalEndMonth['february'] + $totalMonth['march'];
        $totalEndMonth['april'] = $totalEndMonth['march'] + $totalMonth['april'];
        $totalEndMonth['may'] = $totalEndMonth['april'] + $totalMonth['may'];
        $totalEndMonth['june'] = $totalEndMonth['may'] + $totalMonth['june'];
        $totalEndMonth['july'] = $totalEndMonth['june'] + $totalMonth['july'];
        $totalEndMonth['august'] = $totalEndMonth['july'] + $totalMonth['august'];
        $totalEndMonth['september'] = $totalEndMonth['august'] + $totalMonth['september'];
        $totalEndMonth['october'] = $totalEndMonth['september'] + $totalMonth['october'];
        $totalEndMonth['november'] = $totalEndMonth['october'] + $totalMonth['november'];
        $totalEndMonth['december'] = $totalEndMonth['november'] + $totalMonth['december'];

        $balanceSheetRecord->availability($totalEndMonth['december']);


        return $totalEndMonth;
    }

}
