<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Socity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProfitLossAccountController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/profitlossaccount", name="profit_loss_account")
     */
    public function index()
    {
        $user = $this->getUser();
        $socity = $user->getSocity();
        $game = $user->getGame();

        $actualYear = $this->actualYear($socity, $game);
        $lastYear = $this->lastYear($socity, $game);




        return $this->render('profit_loss_account/index.html.twig', [
            'controller_name' => 'ProfitLossAccountController',
            'actualYear' => $actualYear,
            'lastYear' => $lastYear,

        ]);
    }

    private function actualYear(Socity $socity, Game $game){
        //TODO return a table to index

        //TODO Parameter must create in entity BalanceSheet
        //TODO change value buy GET PARAMETER

        $frenchGoodsSale = 1200;
        $internationalGoodsSale = 1200;
        $frenchProductionSoldGoods = 1500;
        $internationalProductionSoldGoods = 1500;
        $frenchProductionSoldServices = 2000;
        $internationalProductionSoldServices = 2000;
        $stockedProduction = 100;
        $operatingGrant = 1000;
        $repaymentOnDepreciationAndProvisions = 1250;
        $otherProduct = 100;
        $goodsPurchases = 1000;
        $changeInStock = 10000;
        $purchasesOfRawMaterialsAndSupplies = 2000;
        $InventoryChange = 3000;
        $otherPurchaseAndExternalCharges = 10;
        $payRoll = $this->payRoll($socity); //TODO change position of function too
        $depreciationAndAmortization = 550;
        $provisions = 05252;
        $provisionOnCurrentAsset = 10;
        $provisionForRiskAndCharge = 25000;
        $otherExpenses= 20;
        $capitalExceptionalOperatingProduct = 20;
        $capitalExceptionalExpense = 10;
        $intestAndSimilarExpenses = 50;
        $intestAndSimilarProduct = 600;




        return $actualYear = $this->profitLosAccountCalculator(
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

    private function lastYear(Socity $socity, Game $game){
        //TODO return a table to index

        //TODO Parameter must create in entity BalanceSheet
        //TODO change value buy GET PARAMETER
        $frenchGoodsSale = 1200;
        $internationalGoodsSale = 1200;
        $frenchProductionSoldGoods = 1500;
        $internationalProductionSoldGoods = 1500;
        $frenchProductionSoldServices = 2000;
        $internationalProductionSoldServices = 2000;
        $stockedProduction = 100;
        $operatingGrant = 1000;
        $repaymentOnDepreciationAndProvisions = 1250;
        $otherProduct = 100;
        $goodsPurchases = 1000;
        $changeInStock = 10000;
        $purchasesOfRawMaterialsAndSupplies = 2000;
        $InventoryChange = 3000;
        $otherPurchaseAndExternalCharges = 10;
        $payRoll = $this->payRoll($socity); //TODO change position of function too
        $depreciationAndAmortization = 550;
        $provisions = 05252;
        $provisionOnCurrentAsset = 10;
        $provisionForRiskAndCharge = 25000;
        $otherExpenses= 20;
        $capitalExceptionalOperatingProduct = 20;
        $capitalExceptionalExpense = 10;
        $intestAndSimilarExpenses = 50;
        $intestAndSimilarProduct = 600;
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
    ){
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
        $totalOperatingRevenue = $this->totalOperatingRevenue($netSales,
            $stockedProduction,
            $operatingGrant,
            $repaymentOnDepreciationAndProvisions,
            $otherProduct);
        $socialCharges = round($this->socialCharges($payRoll, $game), 2);
        $salariesAndTreatments = round($this->salariesAndTreatments($payRoll, $socialCharges),2);
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
        $totalProduct = $this->totalProduct($totalOperatingRevenue,
            $totalFinancialProduct,
            $capitalExceptionalOperatingProduct);
        $financialResult = $this->financialResult($totalFinanceExpenses, $totalFinancialProduct);
        $resultBeforeTax = $this->resultBeforeTax($operatingResult, $financialResult );
        $profitTax = $this->profitTax($resultBeforeTax, $exceptionalResult, $game);
        $employeesParticipation = $this->employeesParticipation($resultBeforeTax, $exceptionalResult, $game);

        $totalExpenses = $this->totalexpenses(
            $totalOperatingExpenses,
            $totalFinanceExpenses,
            $totalFinancialProduct,
            $employeesParticipation,
            $profitTax);
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
    private function profitLoss($totalProduct, $totalExpenses){
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
        $profitTax){

        return $totalExpenses =
            $totalFinancialExpenses +
            $capitalExceptionalExpense+
            $profitTax+
            $salariesParticipation+
            $totalOperatingExpense;
    }


    private function totalProduct(
        $totalOperatingRevenue,
        $totalFinancialProduct,
        $capitalExceptionalOperatingProduct){
                return $totalProduct =
                    $totalFinancialProduct+
                    $capitalExceptionalOperatingProduct+
                    $totalOperatingRevenue;
    }


    private function profitTax($resultBeforeTax, $exceptionalResult, Game $game){

        if (($resultBeforeTax + $exceptionalResult) >= 0){
            return $profitTax = ($exceptionalResult + $resultBeforeTax)*$game->getTaxRate();
        }

        else{
            return $profitTax = 0;
        }
    }

    private function employeesParticipation($resultBeforeTax, $exceptionalResult, Game $game){

        $employeesParticipation = ($resultBeforeTax + $exceptionalResult)*$game->getEmployeeParticipation();
        if($employeesParticipation > 0){
            return $employeesParticipation;
        }
        else{
          return 0;
        }
    }

    /**
     * @param $capitalExceptionalOperatingProduct
     * @param $capitalExceptionalExpense
     * @return mixed
     */
    private function exceptionalResult($capitalExceptionalOperatingProduct, $capitalExceptionalExpense){
        return $exceptionalResult = $capitalExceptionalExpense + $capitalExceptionalOperatingProduct;
    }

    private function resultBeforeTax($operatingResult, $financialResult ){
        return $resultBeforeTax =  $operatingResult + $financialResult;
    }

    private function financialResult($totalFinanceExpenses, $totalFinancialProduct){
        return $financialResult = $totalFinanceExpenses + $totalFinancialProduct;
    }

    private function totalFinanceExpenses($intestAndSimilarExpenses){
        return $intestAndSimilarExpenses;
    }

    private function totalFinancialProduct($intestAndSimilarProduct){
        return $intestAndSimilarProduct;
    }

    private function operatingResult($totalOperatingRevenue, $totalOperatingExpenses){
        return $operatingResult = $totalOperatingRevenue - $totalOperatingExpenses;
    }

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
        ){
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


    private function socialCharges($payRoll, Game $game){
        $employerContributions = $game->getEmployerContributions();
        return $socialCharges = $payRoll*$employerContributions/100;
    }

    private function salariesAndTreatments($payRoll, $socialCharges){
        return $salariesAndTreatments = $payRoll-$socialCharges;
    }

    private function payRoll(Socity $socity){
        $payRoll = 0;
        $employees = $socity->getHumanRessourcies();
        foreach ($employees as $employee){
            $payRoll += $employee->getSalary();
        }
        return round($payRoll, 2);
    }

    private function taxesAndSimilarPayment($netTurnover, Game $game, $salariesAndTreatments){
        $taxeTurnover = $game->getTaxTurnOver();
        $payTax = $game->getPayTax();

        return $taxesAndSimilarPayment = $taxeTurnover*$netTurnover + $salariesAndTreatments*$payTax;
    }

    private function frenchNetSales($goodsSale, $productionSoldGoods, $productionSoldServices){
        return $frenchNetSales = $goodsSale + $productionSoldGoods + $productionSoldServices;
    }

    private function internationalNetSales($goodsSale, $productionSoldGoods, $productionSoldServices){
        return $internationalNetSales = $goodsSale + $productionSoldGoods + $productionSoldServices;
    }

    private function netSales($frenchNetSales, $internationalNetSales){
        return $netSales = $frenchNetSales + $internationalNetSales;
    }

    private function totalOperatingRevenue($netSales,
                                           $stockedProduction,
                                           $operatingGrant,
                                           $repaymentOnDepreciationAndProvisions,
                                           $otherProduct){
        return $totalOperatingRevenue=     $netSales +
                                           $stockedProduction+
                                           $operatingGrant+
                                           $repaymentOnDepreciationAndProvisions+
                                           $otherProduct;

    }




}
