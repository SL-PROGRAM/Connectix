<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Socity;
use App\Repository\AdministrationRepository;
use App\Repository\BalanceSheetRepository;
use App\Repository\FactoryRepository;
use App\Repository\LoanRepository;
use App\Repository\ProductionLignRepository;
use App\Repository\ProductionOrderRepository;
use App\Repository\ProductionRepository;
use App\Repository\PublicityOrderRepository;
use App\Repository\PurchaseOrderRepository;
use App\Repository\ResearcherRepository;
use App\Repository\SalesManParticularRepository;
use App\Repository\SalesManProfessionalRepository;
use App\Repository\SalesManRepository;
use App\Repository\SalesOrderRepository;
use App\Service\BalanceSheetCall;
use App\Service\BalanceSheetRecord;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class ProfitLossAccountController
 * @package App\Controller
 */
class ProfitLossAccountController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/profitlossaccount", name="profit_loss_account")
     */
    /**
     * @param SalesOrderRepository $salesOrderRepository
     * @param PurchaseOrderRepository $purchaseOrderRepository
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRecord $balanceSheetRecord
     * @param AdministrationRepository $administrationRepository
     * @param SalesManRepository $salesManRepository
     * @param ResearcherRepository $researcherRepository
     * @param SalesManProfessionalRepository $salesManProfessionalRepository
     * @param SalesManParticularRepository $salesManParticularRepository
     * @param ProductionOrderRepository $productionOrderRepository
     * @param PublicityOrderRepository $publicityOrderRepository
     * @param FactoryRepository $factoryRepository
     * @param ProductionLignRepository $productionLignRepository
     * @param LoanRepository $loanRepository
     * @param ProductionRepository $productionRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SalesOrderRepository  $salesOrderRepository,
                          PurchaseOrderRepository $purchaseOrderRepository,
                          BalanceSheetRepository $balanceSheetRepository,
                          BalanceSheetCall $balanceSheetCall,
                          BalanceSheetRecord $balanceSheetRecord,
                           AdministrationRepository $administrationRepository,
                           SalesManRepository $salesManRepository,
                           ResearcherRepository $researcherRepository,
                           SalesManProfessionalRepository $salesManProfessionalRepository,
                           SalesManParticularRepository $salesManParticularRepository,
                           ProductionOrderRepository $productionOrderRepository,
                          PublicityOrderRepository $publicityOrderRepository,
                          FactoryRepository $factoryRepository,
                          ProductionLignRepository $productionLignRepository,
                          LoanRepository $loanRepository,
                           ProductionRepository $productionRepository
                            )
    {
        $user = $this->getUser();
        $socity = $user->getSocity();
        $game = $user->getGame();
        $turn = $game->getTurn();
        $status = 0;


        $balanceSheetRecord->record($socity,
                           $turn,
                           $status,
                            $administrationRepository,
                            $salesManRepository,
                            $researcherRepository,
                            $salesManProfessionalRepository,
                            $salesManParticularRepository,
                            $productionRepository,
                            $salesOrderRepository,
                            $purchaseOrderRepository,
                            $productionOrderRepository,
                            $publicityOrderRepository,
                            $loanRepository,
                            $factoryRepository,
                            $productionLignRepository,
                            $balanceSheetRepository);


        $actualYear = $this->actualYear($socity, $game,
            $balanceSheetCall,
            $balanceSheetRecord,
            $balanceSheetRepository);


        $lastYear = $this->lastYear( $socity,  $game,
                               $balanceSheetCall,
                               $balanceSheetRepository);




        return $this->render('profit_loss_account/index.html.twig', [
            'controller_name' => 'ProfitLossAccountController',
            'actualYear' => $actualYear,
            'lastYear' => $lastYear,

        ]);
    }

    /**
     * @param Socity $socity
     * @param Game $game
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRecord $balanceSheetRecord
     * @param BalanceSheetRepository $balanceSheetRepository
     * @return array
     */
    private function actualYear(Socity $socity, Game $game,
                                BalanceSheetCall $balanceSheetCall,
                                BalanceSheetRecord $balanceSheetRecord,
                                BalanceSheetRepository $balanceSheetRepository)
    {

        $turn = $game->getTurn();


        $frenchGoodsSale = $balanceSheetCall->frenchGoodsSale($socity, $turn, $balanceSheetRepository);
        $frenchProductionSoldGoods = $balanceSheetCall->frenchProductionSoldGoods($socity, $turn, $balanceSheetRepository);
        $stockedProduction = $balanceSheetCall->stockedProduction($socity, $turn, $balanceSheetRepository);

        $repaymentOnDepreciationAndProvisions = $balanceSheetCall->repaymentOnDepreciationAndProvisions($socity, $turn, $balanceSheetRepository);
        $goodsPurchases = $balanceSheetCall->goodsPurchases($socity, $turn, $balanceSheetRepository);
        $changeInStock = $balanceSheetCall->changeInStock($socity, $turn, $balanceSheetRepository);
        $purchasesOfRawMaterialsAndSupplies = $balanceSheetCall->purchasesOfRawMaterialsAndSupplies($socity, $turn, $balanceSheetRepository);
        $otherPurchaseAndExternalCharges = $balanceSheetCall->otherPurchaseAndExternalCharges($socity, $turn, $balanceSheetRepository);
        $payRoll = $balanceSheetCall->payRoll($socity, $turn, $balanceSheetRepository);
        $depreciationAndAmortization = $balanceSheetCall->depreciationAndAmortization($socity, $turn, $balanceSheetRepository);
        $intestAndSimilarExpenses = $balanceSheetCall->intestAndSimilarExpenses($socity, $turn, $balanceSheetRepository);





        /*
         * Parameter not use in the game
         */
        $internationalGoodsSale = 0;
        $internationalProductionSoldGoods = 0;
        $frenchProductionSoldServices = 0;
        $internationalProductionSoldServices = 0;
        $operatingGrant = 0;
        $otherProduct = 0;
        $InventoryChange = 0;
        $provisions = 0;
        $provisionOnCurrentAsset = 0;
        $provisionForRiskAndCharge = 0;
        $otherExpenses= 0;
        $capitalExceptionalOperatingProduct = 0;
        $capitalExceptionalExpense = 0;
        $intestAndSimilarProduct = 0;





        $actualYear = $this->profitLosAccountCalculator(
            $frenchGoodsSale,
            $internationalGoodsSale,
            $frenchProductionSoldGoods,
            $internationalProductionSoldGoods,
            $frenchProductionSoldServices,
            $internationalProductionSoldServices,
            $stockedProduction,
            $operatingGrant,
            $repaymentOnDepreciationAndProvisions,
            $otherProduct,
            $goodsPurchases,
            $changeInStock,
            $purchasesOfRawMaterialsAndSupplies,
            $InventoryChange,
            $otherPurchaseAndExternalCharges,
            $payRoll,
            $depreciationAndAmortization,
            $provisions,
            $provisionOnCurrentAsset,
            $provisionForRiskAndCharge,
            $otherExpenses,
            $capitalExceptionalOperatingProduct,
            $capitalExceptionalExpense,
            $intestAndSimilarExpenses,
            $intestAndSimilarProduct,
            $game
        );

        $profitLoss = $actualYear['profitLoss'];
        $balanceSheetRecord->recordProfitYears($socity, $turn, $profitLoss, $balanceSheetRepository);


        return $actualYear;
    }


    /**
     * @param Socity $socity
     * @param Game $game
     * @param BalanceSheetCall $balanceSheetCall
     * @param BalanceSheetRepository $balanceSheetRepository
     * @return array
     */
    private function lastYear(Socity $socity, Game $game,
                              BalanceSheetCall $balanceSheetCall,
                              BalanceSheetRepository $balanceSheetRepository)
    {

        $turn = $game->getTurn()-1;

        $frenchGoodsSale = $balanceSheetCall->frenchGoodsSale($socity, $turn, $balanceSheetRepository);
        $frenchProductionSoldGoods = $balanceSheetCall->frenchProductionSoldGoods($socity, $turn, $balanceSheetRepository);
        $stockedProduction = $balanceSheetCall->stockedProduction($socity, $turn, $balanceSheetRepository);

        $repaymentOnDepreciationAndProvisions = $balanceSheetCall->repaymentOnDepreciationAndProvisions($socity, $turn, $balanceSheetRepository);
        $goodsPurchases = $balanceSheetCall->goodsPurchases($socity, $turn, $balanceSheetRepository);
        $changeInStock = $balanceSheetCall->changeInStock($socity, $turn, $balanceSheetRepository);
        $purchasesOfRawMaterialsAndSupplies = $balanceSheetCall->purchasesOfRawMaterialsAndSupplies($socity, $turn, $balanceSheetRepository);
        $otherPurchaseAndExternalCharges = $balanceSheetCall->otherPurchaseAndExternalCharges($socity, $turn, $balanceSheetRepository);
        $payRoll = $balanceSheetCall->payRoll($socity,  $turn, $balanceSheetRepository);
        $depreciationAndAmortization = $balanceSheetCall->depreciationAndAmortization($socity, $turn, $balanceSheetRepository);
        $intestAndSimilarExpenses = $balanceSheetCall->intestAndSimilarExpenses($socity, $turn, $balanceSheetRepository);





        /*
         * Parameter not use in the game
         */
        $internationalGoodsSale = 0;
        $internationalProductionSoldGoods = 0;
        $frenchProductionSoldServices = 0;
        $internationalProductionSoldServices = 0;
        $operatingGrant = 0;
        $otherProduct = 0;
        $InventoryChange = 0;
        $provisions = 0;
        $provisionOnCurrentAsset = 0;
        $provisionForRiskAndCharge = 0;
        $otherExpenses= 0;
        $capitalExceptionalOperatingProduct = 0;
        $capitalExceptionalExpense = 0;
        $intestAndSimilarProduct = 0;




        return $lastYear = $this->profitLosAccountCalculator(
            $frenchGoodsSale,
            $internationalGoodsSale,
            $frenchProductionSoldGoods,
            $internationalProductionSoldGoods,
            $frenchProductionSoldServices,
            $internationalProductionSoldServices,
            $stockedProduction,
            $operatingGrant,
            $repaymentOnDepreciationAndProvisions,
            $otherProduct,
            $goodsPurchases,
            $changeInStock,
            $purchasesOfRawMaterialsAndSupplies,
            $InventoryChange,
            $otherPurchaseAndExternalCharges,
            $payRoll,
            $depreciationAndAmortization,
            $provisions,
            $provisionOnCurrentAsset,
            $provisionForRiskAndCharge,
            $otherExpenses,
            $capitalExceptionalOperatingProduct,
            $capitalExceptionalExpense,
            $intestAndSimilarExpenses,
            $intestAndSimilarProduct,
            $game
        );
    }


    /**
     * @param $frenchGoodsSale
     * @param $internationalGoodsSale
     * @param $frenchProductionSoldGoods
     * @param $internationalProductionSoldGoods
     * @param $frenchProductionSoldServices
     * @param $internationalProductionSoldServices
     * @param $stockedProduction
     * @param $operatingGrant
     * @param $repaymentOnDepreciationAndProvisions
     * @param $otherProduct
     * @param $goodsPurchases
     * @param $changeInStock
     * @param $purchasesOfRawMaterialsAndSupplies
     * @param $InventoryChange
     * @param $otherPurchaseAndExternalCharges
     * @param $payRoll
     * @param $depreciationAndAmortization
     * @param $provisions
     * @param $provisionOnCurrentAsset
     * @param $provisionForRiskAndCharge
     * @param $otherExpenses
     * @param $capitalExceptionalOperatingProduct
     * @param $capitalExceptionalExpense
     * @param $intestAndSimilarExpenses
     * @param $intestAndSimilarProduct
     * @param Game $game
     * @return array
     */
    private function profitLosAccountCalculator(
        $frenchGoodsSale,
        $internationalGoodsSale,
        $frenchProductionSoldGoods,
        $internationalProductionSoldGoods,
        $frenchProductionSoldServices,
        $internationalProductionSoldServices,
        $stockedProduction,
        $operatingGrant,
        $repaymentOnDepreciationAndProvisions,
        $otherProduct,
        $goodsPurchases,
        $changeInStock,
        $purchasesOfRawMaterialsAndSupplies,
        $InventoryChange,
        $otherPurchaseAndExternalCharges,
        $payRoll,
        $depreciationAndAmortization,
        $provisions,
        $provisionOnCurrentAsset,
        $provisionForRiskAndCharge,
        $otherExpenses,
        $capitalExceptionalOperatingProduct,
        $capitalExceptionalExpense,
        $intestAndSimilarExpenses,
        $intestAndSimilarProduct,
        Game $game
    ) {
        $frenchNetSales = $this->frenchNetSales(
            $frenchProductionSoldGoods,
            $frenchGoodsSale,
            $frenchProductionSoldServices
        );
        $internationalNetSales = $this->internationalNetSales(
            $internationalGoodsSale,
            $internationalProductionSoldGoods,
            $internationalProductionSoldServices
        );
        $netSales = $this->netSales($frenchNetSales, $internationalNetSales);
        $totalOperatingRevenue = $this->totalOperatingRevenue(
            $netSales,
            $stockedProduction,
            $operatingGrant,
            $repaymentOnDepreciationAndProvisions,
            $otherProduct
        );
        $socialCharges = round($this->socialCharges($payRoll, $game), 2);
        $salariesAndTreatments = round($this->salariesAndTreatments($payRoll, $socialCharges), 2);
        $taxesAndSimilarPayment = $this->taxesAndSimilarPayment($netSales, $game, $salariesAndTreatments);
        $totalOperatingExpenses = $this->totalOperatingExpenses(
            $goodsPurchases,
            $changeInStock,
            $purchasesOfRawMaterialsAndSupplies,
            $InventoryChange,
            $otherPurchaseAndExternalCharges,
            $taxesAndSimilarPayment,
            $salariesAndTreatments,
            $socialCharges,
            $depreciationAndAmortization,
            $provisions,
            $provisionOnCurrentAsset,
            $provisionForRiskAndCharge,
            $otherExpenses
        );
        $totalFinanceExpenses = $this->totalFinanceExpenses($intestAndSimilarExpenses);
        $operatingResult = $this->operatingResult($totalOperatingRevenue, $totalOperatingExpenses);
        $totalFinancialProduct = $this->totalFinancialProduct($intestAndSimilarProduct);
        $exceptionalResult = $this->exceptionalResult($capitalExceptionalOperatingProduct, $capitalExceptionalExpense);
        $totalProduct = $this->totalProduct(
            $totalOperatingRevenue,
            $totalFinancialProduct,
            $capitalExceptionalOperatingProduct
        );
        $financialResult = $this->financialResult($totalFinanceExpenses, $totalFinancialProduct);
        $resultBeforeTax = $this->resultBeforeTax($operatingResult, $financialResult);
        $profitTax = $this->profitTax($resultBeforeTax, $exceptionalResult, $game);
        $employeesParticipation = $this->employeesParticipation($resultBeforeTax, $exceptionalResult, $game);

        $totalExpenses = $this->totalexpenses(
            $totalOperatingExpenses,
            $totalFinanceExpenses,
            $totalFinancialProduct,
            $employeesParticipation,
            $profitTax
        );
        $profitLoss = $this->profitLoss($totalProduct, $totalExpenses);




        return $profitLosAccountCalculator = [
            "frenchGoodsSale" => $frenchGoodsSale,
            "internationalGoodsSale" => $internationalGoodsSale,
            "goodsSale" => ($internationalGoodsSale+$frenchGoodsSale),
            "frenchProductionSoldGoods" => $frenchProductionSoldGoods,
            "internationalProductionSoldGoods" => $internationalProductionSoldGoods,
            "productionSoldGoods" => ($internationalProductionSoldGoods+$frenchProductionSoldGoods),
            "frenchProductionSoldServices" => $frenchProductionSoldServices,
            "internationalProductionSoldServices" => $internationalProductionSoldServices,
            "productionSoldServices" => ($internationalProductionSoldServices + $frenchProductionSoldServices),
            "frenchNetSales" => $frenchNetSales,
            "internationalNetSales" => $internationalNetSales,
            "netSales" => $netSales,
            "stockedProduction" => $stockedProduction,
            "operatingGrant" => $operatingGrant,
            "repaymentOnDepreciationAndProvisions" =>$repaymentOnDepreciationAndProvisions,
            "otherProduct" => $otherProduct,
            "totalOperatingRevenue" => $totalOperatingRevenue,
            "goodsPurchases" => $goodsPurchases,
            "changeInStock" => $changeInStock,
            "purchasesOfRawMaterialsAndSupplies" => $purchasesOfRawMaterialsAndSupplies,
            "InventoryChange" => $InventoryChange,
            "otherPurchaseAndExternalCharges" => $otherPurchaseAndExternalCharges,
            "taxesAndSimilarPayment" => $taxesAndSimilarPayment,
            "salariesAndTreatments" => $salariesAndTreatments,
            "socialCharges" => $socialCharges,
            "depreciationAndAmortization" => $depreciationAndAmortization,
            "provisions" => $provisions,
            "provisionOnCurrentAsset" => $provisionOnCurrentAsset,
            "provisionForRiskAndCharge" => $provisionForRiskAndCharge,
            "otherExpenses" => $otherExpenses,
            "totalOperatingExpenses" => $totalOperatingExpenses,
            "operatingResult" => $operatingResult,
            "interestAndSimilarProduct" => $intestAndSimilarProduct,
            "totalFinancialProduct" => $totalFinancialProduct,
            "interestAndSimilarExpenses" => $intestAndSimilarExpenses,
            "totalFinanceExpenses" => $totalFinanceExpenses,
            "financialResult" => $financialResult,
            "capitalExceptionalOperatingProduct" => $capitalExceptionalOperatingProduct,
            "capitalExceptionalExpense" => $capitalExceptionalExpense,
            "exceptionalResult" => $exceptionalResult,
            "resultBeforeTax" => $resultBeforeTax,
            "profitTax" => $profitTax,
            "employeesParticipation" => $employeesParticipation,
            "totalExpenses" => $totalExpenses,
            "profitLoss" => $profitLoss,


            "totalProduct" => $totalProduct,
        ];
    }

    /**
     * @param $totalProduct
     * @param $totalExpenses
     * @return mixed
     */
    private function profitLoss($totalProduct, $totalExpenses)
    {
        return $profitLoss = $totalProduct - $totalExpenses;
    }

    /**
     * @param $totalOperatingExpense
     * @param $totalFinancialExpenses
     * @param $capitalExceptionalExpense
     * @param $salariesParticipation
     * @param $profitTax
     * @return mixed
     */
    private function totalexpenses(
        $totalOperatingExpense,
        $totalFinancialExpenses,
        $capitalExceptionalExpense,
        $salariesParticipation,
        $profitTax
    ) {
        return $totalExpenses =
            $totalFinancialExpenses +
            $capitalExceptionalExpense+
            $profitTax+
            $salariesParticipation+
            $totalOperatingExpense;
    }


    /**
     * @param $totalOperatingRevenue
     * @param $totalFinancialProduct
     * @param $capitalExceptionalOperatingProduct
     * @return mixed
     */
    private function totalProduct(
        $totalOperatingRevenue,
        $totalFinancialProduct,
        $capitalExceptionalOperatingProduct
    ) {
        return $totalProduct =
                    $totalFinancialProduct+
                    $capitalExceptionalOperatingProduct+
                    $totalOperatingRevenue;
    }


    /**
     * @param $resultBeforeTax
     * @param $exceptionalResult
     * @param Game $game
     * @return float|int
     */
    private function profitTax($resultBeforeTax, $exceptionalResult, Game $game)
    {
        if (($resultBeforeTax + $exceptionalResult) >= 0) {
            return $profitTax = (($exceptionalResult + $resultBeforeTax)*$game->getTaxRate())/100;
        } else {
            return $profitTax = 0;
        }
    }

    /**
     * @param $resultBeforeTax
     * @param $exceptionalResult
     * @param Game $game
     * @return float|int
     */
    private function employeesParticipation($resultBeforeTax, $exceptionalResult, Game $game)
    {
        $employeesParticipation = (($resultBeforeTax + $exceptionalResult)*$game->getEmployeeParticipation())/100;
        if ($employeesParticipation > 0) {
            return $employeesParticipation;
        } else {
            return 0;
        }
    }

    /**
     * @param $capitalExceptionalOperatingProduct
     * @param $capitalExceptionalExpense
     * @return mixed
     */
    private function exceptionalResult($capitalExceptionalOperatingProduct, $capitalExceptionalExpense)
    {
        return $exceptionalResult = $capitalExceptionalExpense + $capitalExceptionalOperatingProduct;
    }

    /**
     * @param $operatingResult
     * @param $financialResult
     * @return mixed
     */
    private function resultBeforeTax($operatingResult, $financialResult)
    {
        return $resultBeforeTax =  $operatingResult + $financialResult;
    }

    /**
     * @param $totalFinanceExpenses
     * @param $totalFinancialProduct
     * @return mixed
     */
    private function financialResult($totalFinanceExpenses, $totalFinancialProduct)
    {
        return $financialResult = $totalFinancialProduct - $totalFinanceExpenses ;
    }

    /**
     * @param $intestAndSimilarExpenses
     * @return mixed
     */
    private function totalFinanceExpenses($intestAndSimilarExpenses)
    {
        return $intestAndSimilarExpenses;
    }

    /**
     * @param $intestAndSimilarProduct
     * @return mixed
     */
    private function totalFinancialProduct($intestAndSimilarProduct)
    {
        return $intestAndSimilarProduct;
    }

    /**
     * @param $totalOperatingRevenue
     * @param $totalOperatingExpenses
     * @return mixed
     */
    private function operatingResult($totalOperatingRevenue, $totalOperatingExpenses)
    {
        return $operatingResult = $totalOperatingRevenue - $totalOperatingExpenses;
    }

    /**
     * @param $goodsPurchases
     * @param $changeInStock
     * @param $purchasesOfRawMaterialsAndSupplies
     * @param $InventoryChange
     * @param $otherPurchaseAndExternalCharges
     * @param $taxesAndSimilarPayment
     * @param $salariesAndTreatments
     * @param $socialCharges
     * @param $depreciationAndAmortization
     * @param $provisions
     * @param $provisionOnCurrentAsset
     * @param $provisionForRiskAndCharge
     * @param $otherExpenses
     * @return mixed
     */
    private function totalOperatingExpenses(
        $goodsPurchases,
        $changeInStock,
        $purchasesOfRawMaterialsAndSupplies,
        $InventoryChange,
        $otherPurchaseAndExternalCharges,
        $taxesAndSimilarPayment,
        $salariesAndTreatments,
        $socialCharges,
        $depreciationAndAmortization,
        $provisions,
        $provisionOnCurrentAsset,
        $provisionForRiskAndCharge,
        $otherExpenses
        ) {
        return $totalOperatingExpenses =
                $goodsPurchases +
                $changeInStock +
                $purchasesOfRawMaterialsAndSupplies +
                $InventoryChange +
                $otherPurchaseAndExternalCharges +
                $taxesAndSimilarPayment +
                $salariesAndTreatments +
                $socialCharges +
                $depreciationAndAmortization +
                $provisions +
                $provisionOnCurrentAsset +
                $provisionForRiskAndCharge +
                $otherExpenses;
    }


    /**
     * @param $payRoll
     * @param Game $game
     * @return float|int
     */
    private function socialCharges($payRoll, Game $game)
    {
        $employerContributions = $game->getEmployerContributions();
        return $socialCharges = $payRoll*$employerContributions/100;
    }

    /**
     * @param $payRoll
     * @param $socialCharges
     * @return mixed
     */
    private function salariesAndTreatments($payRoll, $socialCharges)
    {
        return $salariesAndTreatments = $payRoll-$socialCharges;
    }


    /**
     * @param $netTurnover
     * @param Game $game
     * @param $salariesAndTreatments
     * @return float|int
     */
    private function taxesAndSimilarPayment($netTurnover, Game $game, $salariesAndTreatments)
    {
        $taxeTurnover = $game->getTaxTurnOver();
        $payTax = $game->getPayTax();

        return $taxesAndSimilarPayment = ($taxeTurnover*$netTurnover + $salariesAndTreatments*$payTax)/100;
    }

    /**
     * @param $goodsSale
     * @param $productionSoldGoods
     * @param $productionSoldServices
     * @return mixed
     */
    private function frenchNetSales($goodsSale, $productionSoldGoods, $productionSoldServices)
    {
        return $frenchNetSales = $goodsSale + $productionSoldGoods + $productionSoldServices;
    }

    /**
     * @param $goodsSale
     * @param $productionSoldGoods
     * @param $productionSoldServices
     * @return mixed
     */
    private function internationalNetSales($goodsSale, $productionSoldGoods, $productionSoldServices)
    {
        return $internationalNetSales = $goodsSale + $productionSoldGoods + $productionSoldServices;
    }

    /**
     * @param $frenchNetSales
     * @param $internationalNetSales
     * @return mixed
     */
    private function netSales($frenchNetSales, $internationalNetSales)
    {
        return $netSales = $frenchNetSales + $internationalNetSales;
    }

    /**
     * @param $netSales
     * @param $stockedProduction
     * @param $operatingGrant
     * @param $repaymentOnDepreciationAndProvisions
     * @param $otherProduct
     * @return mixed
     */
    private function totalOperatingRevenue(
        $netSales,
        $stockedProduction,
        $operatingGrant,
        $repaymentOnDepreciationAndProvisions,
        $otherProduct
    ) {
        return $totalOperatingRevenue=     $netSales +
                                           $stockedProduction+
                                           $operatingGrant+
                                           $repaymentOnDepreciationAndProvisions+
                                           $otherProduct;
    }
}
