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

class CashFlowController extends AbstractController
{
    /**
     * @Route("/cashflow", name="cash_flow")
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
        $tva = $game->getTva()/100;

        //FOR CALCULATION
        $monthlyRowMaterialHTPurchase = $this->monthlyRowMaterialHTPurchase($socity, $turn, $productionOrderRepository);
        $monthlyMerchandiseHTPurchase = $this->monthlyMerchandiseHTPurchase($socity, $turn, $purchaseOrderRepository);
        $personnelCostBrut = $this->personnelCostBrut($socity, $turn, $balanceSheetCall,$balanceSheetRepository);
        $monthlyMerchandiseHTSales = $this->monthlyMerchandiseHTSales($socity, $turn, $salesOrderRepository);


        //CASH INCLUDES TTC
        $cashingSales = $this->cashingSales();

        $capitalContribution = $this->capitalContribution($socity, $turn, $balanceSheetCall,$balanceSheetRepository);
        $mediumAndLongLoan = $this->mediumAndLongLoan($socity, $turn, $balanceSheetCall,$balanceSheetRepository);
        $creditTVA = $this->creditTVA();
        $transferOfCapital = $this->transfertOfCapital();


        //DISBURSEMENTS TTC


        $monthlyRowMaterialTTCPurchase = $this->monthlyRowMaterialTTCPurchase($monthlyRowMaterialHTPurchase, $tva);
        $monthlyMerchandiseTTCPurchase = $this->monthlyMerchandiseTTCPurchase($monthlyMerchandiseHTPurchase, $tva);
        $externalCharges = $this->externalCharges($socity, $turn, $balanceSheetCall,$balanceSheetRepository);
        $personnelCostNet = $this->personnelCostNet($personnelCostBrut, $game);
        $socialTaxes = $this->socialTaxes($personnelCostBrut, $game);
        $dueAndTaxes =  $this->dueAndTaxes($monthlyMerchandiseHTSales, $personnelCostBrut, $game);
        $financialExpenses = $this->financialExpenses($socity, $turn, $balanceSheetCall,$balanceSheetRepository);
        $dueTVA = $this->dueTVA();
        $tangibleInvestments = $this->tangibleInvestments($socity, $turn, $balanceSheetCall,$balanceSheetRepository, $tva);
        $repaymentOfLoan = $this->repaymentOfLoan($socity, $loanRepository);

        //VAT CALCULATION


        $monthlyCollectedTVA = $this->collectedTVA($monthlyMerchandiseHTSales, $tva);
        $monthlyDedectibleTVA = $this->deductedTVA($monthlyRowMaterialHTPurchase, $monthlyMerchandiseHTPurchase, $externalCharges, $tangibleInvestments,$tva );


        $this->TvaRepartition($dueTVA, $creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, $balanceSheetCall, $balanceSheetRecord);



        //TOTAL
        $totalCashing = $this->totalCaching($cashingSales, $capitalContribution, $mediumAndLongLoan, $creditTVA, $transferOfCapital);
        $totalDisturb = $this->totalDisturb($monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan);





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
        ]);
    }



    private function monthlyRowMaterialHTPurchase(Socity $socity, $turn, ProductionOrderRepository $repository){
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
        foreach ( $productionOrders as $productionOrder){
            $product = $productionOrder->getProduct();
            $monthlyAvgProductionCost = $productionOrder->getRowMaterialCost()/12;

            $monthlyProductionCost['january' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getJanuary(), 2);
            $monthlyProductionCost['february' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getFebruary(), 2);
            $monthlyProductionCost['march' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getMarch(), 2);
            $monthlyProductionCost['april' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getApril(), 2);
            $monthlyProductionCost['may' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getMay(), 2);
            $monthlyProductionCost['june' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getJune(), 2);
            $monthlyProductionCost['july' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getJuly(), 2);
            $monthlyProductionCost['august' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getAugust(), 2);
            $monthlyProductionCost['september' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getSeptember(), 2);
            $monthlyProductionCost['october' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getOctober(), 2);
            $monthlyProductionCost['november' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getNovember(), 2);
            $monthlyProductionCost['december' ] += round($monthlyAvgProductionCost*$product->getSeasonality()->getDecember(), 2);
        }
        return $monthlyProductionCost;
    }

    private function monthlyMerchandiseHTPurchase(Socity $socity, $turn, PurchaseOrderRepository $repository){
        $monthlyMerchandiseTTCPurchase = [
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
        foreach ( $orders as $order){
            $product = $order->getProduct();
            $monthlyAvgCost = ($order->getProductQuantityPurchase()*$order->getPurchasePrice()/12);

            $monthlyMerchandiseTTCPurchase['january' ] += round($monthlyAvgCost*$product->getSeasonality()->getJanuary(), 2);
            $monthlyMerchandiseTTCPurchase['february' ] += round($monthlyAvgCost*$product->getSeasonality()->getFebruary(), 2);
            $monthlyMerchandiseTTCPurchase['march' ] += round($monthlyAvgCost*$product->getSeasonality()->getMarch(), 2);
            $monthlyMerchandiseTTCPurchase['april' ] += round($monthlyAvgCost*$product->getSeasonality()->getApril(), 2);
            $monthlyMerchandiseTTCPurchase['may' ] += round($monthlyAvgCost*$product->getSeasonality()->getMay(), 2);
            $monthlyMerchandiseTTCPurchase['june' ] += round($monthlyAvgCost*$product->getSeasonality()->getJune(), 2);
            $monthlyMerchandiseTTCPurchase['july' ] += round($monthlyAvgCost*$product->getSeasonality()->getJuly(), 2);
            $monthlyMerchandiseTTCPurchase['august' ] += round($monthlyAvgCost*$product->getSeasonality()->getAugust(), 2);
            $monthlyMerchandiseTTCPurchase['september' ] += round($monthlyAvgCost*$product->getSeasonality()->getSeptember(), 2);
            $monthlyMerchandiseTTCPurchase['october' ] += round($monthlyAvgCost*$product->getSeasonality()->getOctober(), 2);
            $monthlyMerchandiseTTCPurchase['november' ] += round($monthlyAvgCost*$product->getSeasonality()->getNovember(), 2);
            $monthlyMerchandiseTTCPurchase['december' ] += round($monthlyAvgCost*$product->getSeasonality()->getDecember(), 2);
        }
        return $monthlyMerchandiseTTCPurchase;
    }

    private function monthlyMerchandiseHTSales(Socity $socity, $turn, SalesOrderRepository $repository){
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
        foreach ( $orders as $order){
            $product = $order->getProduct();
            $monthlyAvgCost = ($order->getProductQuantitySales()*$order->getSalesPrice()/12);

            $monthlyMerchandiseHTSales['january' ] += round($monthlyAvgCost*$product->getSeasonality()->getJanuary(), 2);
            $monthlyMerchandiseHTSales['february' ] += round($monthlyAvgCost*$product->getSeasonality()->getFebruary(), 2);
            $monthlyMerchandiseHTSales['march' ] += round($monthlyAvgCost*$product->getSeasonality()->getMarch(), 2);
            $monthlyMerchandiseHTSales['april' ] += round($monthlyAvgCost*$product->getSeasonality()->getApril(), 2);
            $monthlyMerchandiseHTSales['may' ] += round($monthlyAvgCost*$product->getSeasonality()->getMay(), 2);
            $monthlyMerchandiseHTSales['june' ] += round($monthlyAvgCost*$product->getSeasonality()->getJune(), 2);
            $monthlyMerchandiseHTSales['july' ] += round($monthlyAvgCost*$product->getSeasonality()->getJuly(), 2);
            $monthlyMerchandiseHTSales['august' ] += round($monthlyAvgCost*$product->getSeasonality()->getAugust(), 2);
            $monthlyMerchandiseHTSales['september' ] += round($monthlyAvgCost*$product->getSeasonality()->getSeptember(), 2);
            $monthlyMerchandiseHTSales['october' ] += round($monthlyAvgCost*$product->getSeasonality()->getOctober(), 2);
            $monthlyMerchandiseHTSales['november' ] += round($monthlyAvgCost*$product->getSeasonality()->getNovember(), 2);
            $monthlyMerchandiseHTSales['december' ] += round($monthlyAvgCost*$product->getSeasonality()->getDecember(), 2);
        }
        return $monthlyMerchandiseHTSales;
    }

    /*
     * DISBURSEMENTS
     */
    private function monthlyRowMaterialTTCPurchase($monthlyRowMaterialHTPurchase, $tva){
        return $monthlyRowMaterialTTCPurchase = [
            'january'  => round($monthlyRowMaterialHTPurchase['january' ] *$tva, 2) ,
            'february'  => round( $monthlyRowMaterialHTPurchase['february' ]*$tva, 2) ,
            'march' => round( $monthlyRowMaterialHTPurchase['march' ]*$tva, 2) ,
            'april'  => round( $monthlyRowMaterialHTPurchase['april' ]*$tva, 2),
            'may'  => round( $monthlyRowMaterialHTPurchase['may' ]*$tva, 2) ,
            'june' => round( $monthlyRowMaterialHTPurchase['june' ]*$tva, 2) ,
            'july' => round( $monthlyRowMaterialHTPurchase['july' ]*$tva, 2) ,
            'august' => round( $monthlyRowMaterialHTPurchase['august' ]*$tva, 2),
            'september' => round( $monthlyRowMaterialHTPurchase['september' ]*$tva, 2),
            'october' => round( $monthlyRowMaterialHTPurchase['october' ]*$tva, 2),
            'november' => round( $monthlyRowMaterialHTPurchase['november' ]*$tva, 2),
            'december' => round( $monthlyRowMaterialHTPurchase['december' ]*$tva, 2),
        ];
    }

    private function monthlyMerchandiseTTCPurchase($monthlyMerchandiseHTPurchase, $tva){
        return $monthlyMerchandiseTTCPurchase = [
            'january'  => round($monthlyMerchandiseHTPurchase['january' ] *$tva, 2) ,
            'february'  => round( $monthlyMerchandiseHTPurchase['february' ]*$tva, 2) ,
            'march' => round( $monthlyMerchandiseHTPurchase['march' ]*$tva, 2) ,
            'april'  => round( $monthlyMerchandiseHTPurchase['april' ]*$tva, 2),
            'may'  => round( $monthlyMerchandiseHTPurchase['may' ]*$tva, 2) ,
            'june' => round( $monthlyMerchandiseHTPurchase['june' ]*$tva, 2) ,
            'july' => round( $monthlyMerchandiseHTPurchase['july' ]*$tva, 2) ,
            'august' => round( $monthlyMerchandiseHTPurchase['august' ]*$tva, 2),
            'september' => round( $monthlyMerchandiseHTPurchase['september' ]*$tva, 2),
            'october' => round( $monthlyMerchandiseHTPurchase['october' ]*$tva, 2),
            'november' => round( $monthlyMerchandiseHTPurchase['november' ]*$tva, 2),
            'december' => round( $monthlyMerchandiseHTPurchase['december' ]*$tva, 2),
        ];
    }

    private function externalCharges($socity, $turn,BalanceSheetCall $balanceSheetCall,BalanceSheetRepository $balanceSheetRepository){
        $monthlyOtherCharge =round($balanceSheetCall->otherPurchaseAndExternalCharges($socity, $turn, $balanceSheetRepository)
            /12,2);

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

    private function personnelCostBrut($socity, $turn,BalanceSheetCall $balanceSheetCall,BalanceSheetRepository $balanceSheetRepository){
        $personnelCost =round($balanceSheetCall->payRoll($socity, $turn, $balanceSheetRepository)
            /12,2);

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

    private function dueAndTaxes($monthlyMerchandiseHTSales, $personnelCostBrut,Game $game){
        $payTax = $game->getPayTax()/100;
        $taxTurnover = $game->getTaxTurnover()/100;

        return $dueAndTaxes = [
            'january'  => round($monthlyMerchandiseHTSales['january' ] *$payTax, 2) +
                round($personnelCostBrut['january' ] *$taxTurnover, 2),
            'february'  => round( $monthlyMerchandiseHTSales['february' ]*$payTax, 2) +
                round( $personnelCostBrut['february' ]*$taxTurnover, 2),
            'march' => round( $monthlyMerchandiseHTSales['march' ]*$payTax, 2) +
                round( $personnelCostBrut['march' ]*$taxTurnover, 2),
            'april'  => round( $monthlyMerchandiseHTSales['april' ]*$payTax, 2) +
                round( $personnelCostBrut['april' ]*$taxTurnover, 2),
            'may'  => round( $monthlyMerchandiseHTSales['may' ]*$payTax, 2) +
                round( $personnelCostBrut['may' ]*$taxTurnover, 2),
            'june' => round( $monthlyMerchandiseHTSales['june' ]*$payTax, 2) +
                round( $personnelCostBrut['june' ]*$taxTurnover, 2),
            'july' => round( $monthlyMerchandiseHTSales['july' ]*$payTax, 2) +
                round( $personnelCostBrut['july' ]*$taxTurnover, 2),
            'august' => round( $monthlyMerchandiseHTSales['august' ]*$payTax, 2) +
                round( $personnelCostBrut['august' ]*$taxTurnover, 2),
            'september' => round( $monthlyMerchandiseHTSales['september' ]*$payTax, 2) +
                round( $personnelCostBrut['september' ]*$taxTurnover, 2),
            'october' => round( $monthlyMerchandiseHTSales['october' ]*$payTax, 2) +
                round( $personnelCostBrut['october' ]*$taxTurnover, 2),
            'november' => round( $monthlyMerchandiseHTSales['november' ]*$payTax, 2) +
                round( $personnelCostBrut['november' ]*$taxTurnover, 2),
            'december' => round( $monthlyMerchandiseHTSales['december' ]*$payTax, 2) +
                round( $personnelCostBrut['december' ]*$taxTurnover, 2),
        ];
    }

    private function personnelCostNet($personnelCostBrut, Game $game){
        $salaryContributions = $game->getSalaryContributions()/100;

        return $personnelCostNet = [
            'january'  => round($personnelCostBrut['january' ] *(1-$salaryContributions), 2),
            'february' => round( $personnelCostBrut['february' ]*(1-$salaryContributions), 2),
            'march' => round( $personnelCostBrut['march' ]*(1-$salaryContributions), 2),
            'april' => round( $personnelCostBrut['april' ]*(1-$salaryContributions), 2),
            'may' => round( $personnelCostBrut['may' ]*(1-$salaryContributions), 2),
            'june' => round( $personnelCostBrut['june' ]*(1-$salaryContributions), 2),
            'july' => round( $personnelCostBrut['july' ]*(1-$salaryContributions), 2),
            'august' => round( $personnelCostBrut['august' ]*(1-$salaryContributions), 2),
            'september' => round( $personnelCostBrut['september' ]*(1-$salaryContributions), 2),
            'october' => round( $personnelCostBrut['october' ]*(1-$salaryContributions), 2),
            'november' => round( $personnelCostBrut['november' ]*(1-$salaryContributions), 2),
            'december' => round( $personnelCostBrut['december' ]*(1-$salaryContributions), 2),
            ];
    }

    private function socialTaxes($personnelCostBrut, Game $game){
        $salaryContributions = $game->getSalaryContributions()/100;
        $employerContributions = $game->getEmployerContributions()/100;

        return $socialTaxes = [
            'january'  => round($personnelCostBrut['january' ] *($employerContributions + $salaryContributions), 2),
            'february' => round( $personnelCostBrut['february' ]*($employerContributions + $salaryContributions), 2),
            'march' => round( $personnelCostBrut['march' ]*($employerContributions + $salaryContributions), 2),
            'april' => round( $personnelCostBrut['april' ]*($employerContributions + $salaryContributions), 2),
            'may' => round( $personnelCostBrut['may' ]*($employerContributions + $salaryContributions), 2),
            'june' => round( $personnelCostBrut['june' ]*($employerContributions + $salaryContributions), 2),
            'july' => round( $personnelCostBrut['july' ]*($employerContributions + $salaryContributions), 2),
            'august' => round( $personnelCostBrut['august' ]*($employerContributions +$salaryContributions), 2),
            'september' => round( $personnelCostBrut['september' ]*($employerContributions + $salaryContributions), 2),
            'october' => round( $personnelCostBrut['october' ]*($employerContributions + $salaryContributions), 2),
            'november' => round( $personnelCostBrut['november' ]*($employerContributions + $salaryContributions), 2),
            'december' => round( $personnelCostBrut['december' ]*($employerContributions + $salaryContributions), 2),
        ];
    }

    private function financialExpenses($socity, $turn,BalanceSheetCall $balanceSheetCall, BalanceSheetRepository $balanceSheetRepository){
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

    private function dueTVA(){
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

    private function tangibleInvestments($socity, $turn, BalanceSheetCall $balanceSheetCall, BalanceSheetRepository $balanceSheetRepository, $tva)
    {
        $groundLastTurn = $balanceSheetCall->grounds($socity, $turn-1, $balanceSheetRepository);
        $productionLignLastTurn = $balanceSheetCall->productionLign($socity, $turn-1, $balanceSheetRepository);
        $factoyLastTurn = $balanceSheetCall->factory($socity, $turn-1, $balanceSheetRepository);
        $groundTurn = $balanceSheetCall->grounds($socity, $turn, $balanceSheetRepository);
        $productionLignTurn = $balanceSheetCall->productionLign($socity, $turn, $balanceSheetRepository);
        $factoyTurn = $balanceSheetCall->factory($socity, $turn, $balanceSheetRepository);

        return $cashingSales = [
            'january' => ($groundTurn-$groundLastTurn+
                $factoyTurn-$factoyLastTurn+
                $productionLignTurn-$productionLignLastTurn)*(1+$tva),
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

    private function repaymentOfLoan($socity, LoanRepository $loanRepository){
        $annualRepayement = 0;
        $loans = $loanRepository->findBy(['socity' => $socity]);
        foreach ($loans as $loan){
            $annualRepayement += $loan->getBorrowAmount()/$loan->getLoanDuration();
        }

        $monthlyRepayement = round($annualRepayement/12,2);
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

    private function cashingSales() {
        return $cashingSales = [
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

    private function capitalContribution(Socity $socity, $turn,BalanceSheetCall $balanceSheetCall,BalanceSheetRepository $balanceSheetRepository){
        $shareCapitalOrIndividuallastTurn = $balanceSheetCall->shareCapitalOrIndividual($socity, $turn-1, $balanceSheetRepository );
        $shareCapitalOrIndividualTurn = $balanceSheetCall->shareCapitalOrIndividual($socity, $turn, $balanceSheetRepository );

        $upShareCapitalOrIndividual = $shareCapitalOrIndividualTurn - $shareCapitalOrIndividuallastTurn;
        if ($upShareCapitalOrIndividual < 0){
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

    private function mediumAndLongLoan(Socity $socity, $turn,BalanceSheetCall $balanceSheetCall,BalanceSheetRepository $balanceSheetRepository){
        $mediumAndLongLoanLastTurn = $balanceSheetCall->loanAndDebtsWihCreditInstitutions($socity, $turn-1, $balanceSheetRepository );
        $mediumAndLongLoanTurn = $balanceSheetCall->loanAndDebtsWihCreditInstitutions($socity, $turn, $balanceSheetRepository );

        $upLoan = $mediumAndLongLoanTurn-$mediumAndLongLoanLastTurn;
        if($upLoan <0){
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

    private function creditTVA(){
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

    private function transfertOfCapital(){
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
    private function collectedTVA($monthlyMerchandiseHTSales, $tva){
        return $monthlyCollectedTVA= [
            'january' => $monthlyMerchandiseHTSales['january']*$tva,
            'february' => $monthlyMerchandiseHTSales['february']*$tva,
            'march' => $monthlyMerchandiseHTSales['march']*$tva,
            'april' => $monthlyMerchandiseHTSales['april']*$tva,
            'may' => $monthlyMerchandiseHTSales['may']*$tva,
            'june' => $monthlyMerchandiseHTSales['june']*$tva,
            'july' => $monthlyMerchandiseHTSales['july']*$tva,
            'august' => $monthlyMerchandiseHTSales['august']*$tva,
            'september' => $monthlyMerchandiseHTSales['september']*$tva,
            'october' => $monthlyMerchandiseHTSales['october']*$tva,
            'november' => $monthlyMerchandiseHTSales['november']*$tva,
            'december' => $monthlyMerchandiseHTSales['december']*$tva,
        ];


    }

    private function deductedTVA($monthlyRowMaterialHTPurchase, $monthlyMerchandiseHTPurchase, $externalCharges, $tangibleInvestments,$tva ){
        return $deductedTVA =[
            'january' => round(($monthlyRowMaterialHTPurchase['january']+ $monthlyMerchandiseHTPurchase['january']+
                $externalCharges['january']+  $tangibleInvestments['january'])
                *$tva/(1+$tva),2),
            'february' => round(($monthlyRowMaterialHTPurchase['february']+ $monthlyMerchandiseHTPurchase['february']+
                    $externalCharges['february']+  $tangibleInvestments['february'])
                *$tva/(1+$tva),2),
            'march' => round(($monthlyRowMaterialHTPurchase['march']+ $monthlyMerchandiseHTPurchase['march']+
                    $externalCharges['march']+  $tangibleInvestments['march'])
                *$tva/(1+$tva),2),
            'april' => round(($monthlyRowMaterialHTPurchase['april']+ $monthlyMerchandiseHTPurchase['april']+
                    $externalCharges['april']+  $tangibleInvestments['april'])
                *$tva/(1+$tva),2),
            'may' => round(($monthlyRowMaterialHTPurchase['may']+ $monthlyMerchandiseHTPurchase['may']+
                    $externalCharges['may']+  $tangibleInvestments['may'])
                *$tva/(1+$tva),2),
            'june' => round(($monthlyRowMaterialHTPurchase['june']+ $monthlyMerchandiseHTPurchase['june']+
                    $externalCharges['june']+  $tangibleInvestments['june'])
                *$tva/(1+$tva),2),
            'july' => round(($monthlyRowMaterialHTPurchase['july']+ $monthlyMerchandiseHTPurchase['july']+
                    $externalCharges['july']+  $tangibleInvestments['july'])
                *$tva/(1+$tva),2),
            'august' => round(($monthlyRowMaterialHTPurchase['august']+ $monthlyMerchandiseHTPurchase['august']+
                    $externalCharges['august']+  $tangibleInvestments['august'])
                *$tva/(1+$tva),2),
            'september' => round(($monthlyRowMaterialHTPurchase['september']+ $monthlyMerchandiseHTPurchase['september']+
                    $externalCharges['september']+  $tangibleInvestments['september'])
                *$tva/(1+$tva),2),
            'october' => round(($monthlyRowMaterialHTPurchase['october']+ $monthlyMerchandiseHTPurchase['october']+
                    $externalCharges['october']+  $tangibleInvestments['october'])
                *$tva/(1+$tva),2),
            'november' => round(($monthlyRowMaterialHTPurchase['november']+ $monthlyMerchandiseHTPurchase['november']+
                    $externalCharges['november']+  $tangibleInvestments['november'])
                *$tva/(1+$tva),2),
            'december' => round(($monthlyRowMaterialHTPurchase['december']+ $monthlyMerchandiseHTPurchase['december']+
                    $externalCharges['december']+  $tangibleInvestments['december'])
                *$tva/(1+$tva),2),
        ];
    }

    private function TvaRepartition(&$dueTVA, &$creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, BalanceSheetCall $balanceSheetCall, BalanceSheetRecord $balanceSheetRecord){

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

    private function recordTVA(&$dueTVA, &$creditTVA, $monthlyCollectedTVA, $monthlyDedectibleTVA, $key, $nextMonth,
                               BalanceSheetCall $balanceSheetCall, BalanceSheetRecord $balanceSheetRecord){
        if ($key === 'january'){
            $tva = round($balanceSheetCall->tva() - $monthlyDedectibleTVA[$key],2);
            if( $tva > 0){
                $dueTVA[$nextMonth] = $tva;
            }
            else{
                $creditTVA[$nextMonth] = $tva;
            }
        }

        if ($key === 'december'){
                $balanceSheetRecord->tva($monthlyCollectedTVA[$key]);
        }

        else{
            $tva = round($monthlyCollectedTVA[$key] - $monthlyDedectibleTVA[$key],2);
            if( $tva > 0){
                $dueTVA[$nextMonth] = $tva;
            }
            else{
                $creditTVA[$nextMonth] = $tva;
            }
        }


}


    private function totalCaching(){

    }

    private function totalDisturb($monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan){
        return $totalDisturb = [
            'january' => $this->totalDisturbCalculation('january',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'february' => $this->totalDisturbCalculation('february',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'march' => $this->totalDisturbCalculation('march',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'april' => $this->totalDisturbCalculation('april',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'may' => $this->totalDisturbCalculation('may',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'june' => $this->totalDisturbCalculation('june',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'july' => $this->totalDisturbCalculation('july',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'august' => $this->totalDisturbCalculation('august',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'september' => $this->totalDisturbCalculation('september',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'october' => $this->totalDisturbCalculation('october',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'november' => $this->totalDisturbCalculation('november',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
            'december' => $this->totalDisturbCalculation('december',$monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan ),
        ];
    }

    private function totalDisturbCalculation($key, $monthlyRowMaterialTTCPurchase, $monthlyMerchandiseTTCPurchase, $externalCharges, $personnelCostNet, $socialTaxes, $dueAndTaxes, $financialExpenses, $dueTVA, $tangibleInvestments, $repaymentOfLoan){
        return $monthlyRowMaterialTTCPurchase[$key] +
            $monthlyMerchandiseTTCPurchase[$key] +
            $externalCharges[$key] +
            $personnelCostNet[$key] +
            $socialTaxes[$key] +
            $dueAndTaxes[$key] +
            $financialExpenses[$key] +
            $dueTVA[$key] +
            $tangibleInvestments[$key] +
            $repaymentOfLoan[$key] ;


    }




//
//    //TODO validation $vatCredit
//    private function totalCashInclude(
//        $cashingSales,
//        $vatCredit,
//        $capitalContribution,
//        $mediumAndLongLoan,
//        $discountBillOfExchange,
//        $transferOfCapital
//    ) {
//        return $totalCashInclude =    $cashingSales+
//                                      $vatCredit+
//                                      $capitalContribution+
//                                      $mediumAndLongLoan+
//                                      $discountBillOfExchange+
//                                      $transferOfCapital;
//    }
//
//    private function totalDisbursement(
//        $monthlyRowMaterialTTCPurchase,
//        $monthlyMerchandiseTTCPurchase,
//        $externalCharges,
//        $dueAndTaxes,
//        $personnelCost,
//        $financialExpenses,
//        $VatToPay,
//        $tangibleInvestments,
//        $repaymentOfLoan
//    ) {
//        return $totalDisbursement =       $monthlyRowMaterialTTCPurchase+
//                                          $monthlyMerchandiseTTCPurchase+
//                                          $externalCharges+
//                                          $dueAndTaxes+
//                                          $personnelCost+
//                                          $financialExpenses+
//                                          $VatToPay+
//                                          $tangibleInvestments+
//                                          $repaymentOfLoan;
//    }
//
//
//    private function balanceOfTheMonth($totalCashInclude, $totalDisbursement)
//    {
//        return $balanceOfTheMonth = $totalCashInclude + $totalDisbursement;
//    }
//
//    private function balanceEndOfMonth($balanceOfTheMonth)
//    {
//        //TODO ADD balanceEndOfMonth of LAST MONTH
//        return $balanceEndOfMonth = $balanceOfTheMonth;
//    }
//
//
//
//
//
//
//    //Function use to calcul VAT
//
//    private function monthlyVATCalculation(
//        Game $game,
//        $monthlyRowMaterialPurchase,
//        $monthlyMerchandisePurchase,
//        $monthlyBillingProductSales,
//        $monthlyOtherCharge,
//        $monthlyImmobilization
//    ) {
//        //TODO CHANGE POSITION OF INCOMING VALUE
//
//        $monthlyCollectedVAT = $this->monthlyCollectedVAT($monthlyBillingProductSales, $game);
//        $monthlyHTPurchase = $this->monthlyHTPurchase($monthlyBillingProductSales, $game);
//        $monthlyRowMaterialTTCPurchase = $this->monthlyTTCPurchase($monthlyRowMaterialPurchase, $game);
//        $monthlyDeductibleVATOnRowMaterial = $this->monthlyDeductibleVATOnRowMaterial($monthlyRowMaterialPurchase, $game);
//        $monthlyDeductibleVATOnMerchandise = $this->monthlyDeductibleVATOnMerchandise($monthlyMerchandisePurchase, $game);
//        $monthlyDeductibleVATOnOtherCharge = $this->monthlyDeductibleVATOnOtherCharge($monthlyOtherCharge, $game);
//        $monthlyDeductibleVATOnImmobilization = $this->monthlyDeductibleVATOnImmobilization($monthlyImmobilization, $game);
//        $monthlyDeductibleVAT = $this->monthlyDeductibleVAT(
//            $monthlyDeductibleVATOnImmobilization,
//            $monthlyDeductibleVATOnOtherCharge,
//            $monthlyDeductibleVATOnMerchandise,
//            $monthlyDeductibleVATOnRowMaterial
//        );
//        $vatCredit = $this->vatCredit($monthlyCollectedVAT, $monthlyDeductibleVAT);
//        $vatToPay = $this->vatToPay($monthlyCollectedVAT, $monthlyDeductibleVAT);
//
//        return $monthlyVATCalculation = [
//            "monthlyCollectedVAT" => $monthlyCollectedVAT,
//            "monthlyHTPurchase" => $monthlyHTPurchase,
//            "monthlyRowMaterialTTCPurchase" => $monthlyRowMaterialTTCPurchase,
//            "monthlyDeductibleVATOnRowMaterial" => $monthlyDeductibleVATOnRowMaterial,
//            "monthlyDeductibleVATOnMerchandise" => $monthlyDeductibleVATOnMerchandise,
//            "monthlyDeductibleVATOnOtherCharge" => $monthlyDeductibleVATOnOtherCharge,
//            "monthlyDeductibleVATOnImmobilization" => $monthlyDeductibleVATOnImmobilization,
//            "monthlyDeductibleVAT" => $monthlyDeductibleVAT,
//            "vatCredit" => $vatCredit,
//            "vatToPay" => $vatToPay
//        ];
//    }
//
//    /**
//     * @param $monthlyBillingProductSales
//     * @param Game $game
//     * @return float|int
//     */
//    private function monthlyCollectedVAT($monthlyBillingProductSales, Game $game)
//    {
//        return $monthlyCollectedVAT = $monthlyBillingProductSales/100*$game->getTva();
//    }
//
//    /**
//     * @param $monthlyBillingProductSales
//     * @param Game $game
//     * @return float|int
//     */
//    private function monthlyHTPurchase($monthlyBillingProductSales, Game $game)
//    {
//        return $htSales = $monthlyBillingProductSales/(100 - $game->getTva());
//    }
//
//
//    /**
//     * @param $monthlyRowMaterialPurchase
//     * @param Game $game
//     * @return float|int
//     */
//    private function monthlyTTCPurchase($monthlyRowMaterialPurchase, Game $game)
//    {
//        return $monthlyTTCPurchase = $monthlyRowMaterialPurchase + ($monthlyRowMaterialPurchase/100 * $game->getTva());
//    }
//
//    /**
//     * @param $monthlyRowMaterialPurchase
//     * @param Game $game
//     * @return float|int
//     */
//    private function monthlyDeductibleVATOnRowMaterial($monthlyRowMaterialPurchase, Game $game)
//    {
//        return $monthlyDeductibleVATOnRowMaterial = $monthlyRowMaterialPurchase/100 * $game->getTva();
//    }
//
//    /**
//     * @param $monthlyMerchandisePurchase
//     * @param Game $game
//     * @return float|int
//     */
//    private function monthlyDeductibleVATOnMerchandise($monthlyMerchandisePurchase, Game $game)
//    {
//        return $monthlyDeductibleVATOnMerchandise = $monthlyMerchandisePurchase/100 * $game->getTva();
//    }
//
//    /**
//     * @param $monthlyOtherCharge
//     * @param Game $game
//     * @return float|int
//     */
//    private function monthlyDeductibleVATOnOtherCharge($monthlyOtherCharge, Game $game)
//    {
//        return $monthlyDeductibleVATOnOtherCharge = $monthlyOtherCharge/100 * $game->getTva();
//    }
//
//    /**
//     * @param $monthlyImmobilization
//     * @param Game $game
//     * @return float|int
//     */
//    private function monthlyDeductibleVATOnImmobilization($monthlyImmobilization, Game $game)
//    {
//        return $monthlyDeductibleVATOnImmobilization = $monthlyImmobilization/100 * $game->getTva();
//    }
//
//    /**
//     * @param $monthlyDeductibleVATOnImmobilization
//     * @param $monthlyDeductibleVATOnOtherCharge
//     * @param $monthlyDeductibleVATOnMerchandise
//     * @param $monthlyDeductibleVATOnRowMaterial
//     * @return mixed
//     */
//    private function monthlyDeductibleVAT(
//        $monthlyDeductibleVATOnImmobilization,
//        $monthlyDeductibleVATOnOtherCharge,
//        $monthlyDeductibleVATOnMerchandise,
//        $monthlyDeductibleVATOnRowMaterial
//    ) {
//        return $monthlyDeductibleVAT =    $monthlyDeductibleVATOnImmobilization+
//                                          $monthlyDeductibleVATOnOtherCharge+
//                                          $monthlyDeductibleVATOnMerchandise+
//                                          $monthlyDeductibleVATOnRowMaterial;
//    }
//
//    /**
//     * @param $monthlyCollectedVAT
//     * @param $monthlyDeductibleVAT
//     * @return int
//     */
//    private function vatCredit($monthlyCollectedVAT, $monthlyDeductibleVAT)
//    {
//        $vatCredit = $monthlyCollectedVAT - $monthlyDeductibleVAT;
//        if ($vatCredit > 0) {
//            return $vatCredit;
//        } else {
//            return 0;
//        }
//    }
//
//    /**
//     * @param $monthlyCollectedVAT
//     * @param $monthlyDeductibleVAT
//     * @return int
//     */
//    private function vatToPay($monthlyCollectedVAT, $monthlyDeductibleVAT)
//    {
//        $vatCredit = $monthlyCollectedVAT - $monthlyDeductibleVAT;
//        if ($vatCredit > 0) {
//            return 0;
//        } else {
//            return $vatCredit;
//        }
//    }
}
