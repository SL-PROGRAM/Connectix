<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\ProductionLign;
use App\Entity\Socity;
use App\Repository\GameRepository;
use App\Repository\SocityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfitLossAccountController extends AbstractController
{
    /**
     * @Route("/profitlossaccount", name="profit_loss_account")
     */
    public function index()
    {
        $user = $this->getUser();
        $socity = $user->getSocity();
        $game = $user->getGame();

        $actualYear = $this->actualYear();




        return $this->render('profit_loss_account/index.html.twig', [
            'controller_name' => 'ProfitLossAccountController',
            'actualYear' => $actualYear,

        ]);
    }

    private function actualYear(){
        //TODO return a table to index
        $goodsSale = 0;
        $productionSoldGoods = 0;
        $productionSoldServices = 0;

        $netSales = $this->netSales($goodsSale, $productionSoldGoods, $productionSoldServices);


         return $actualYear = [
            "goodsSale" => $goodsSale,
            "productionSoldGoods" => $productionSoldGoods,
            "productionSoldServices" => $productionSoldServices,
            "netSales" => $netSales,


        ];


    }

    private function lastYear(){
        //TODO return a table to index
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

    /**
     * @param $totalFinancialProduct
     * @param $capitalExceptionalOperatingProduct
     * @param $operatingProduct
     * @return mixed
     */
    private function totalProduct($totalFinancialProduct, $capitalExceptionalOperatingProduct, $operatingProduct){
        return $totalProduct = $totalFinancialProduct+$capitalExceptionalOperatingProduct+$operatingProduct;
    }


    private function profitTax($resultBeforeTax, $exceptionalResult){

        if (($resultBeforeTax + $exceptionalResult) >= 0){
            //TODO change 0.28 by tax rate in Game entity
            return $profitTax = ($exceptionalResult + $resultBeforeTax)*0.28;
        }

        else{
            return $profitTax = 0;
        }
    }

    private function employeesParticipation($resultBeforeTax, $exceptionalResult){

        //TODO change 0.05 by emploiesParticipation rate in game entity
        return $employeesParticipation = ($resultBeforeTax + $exceptionalResult)*0.05;
    }

    /**
     * @param $capitalExceptionalOperatingProduct
     * @param $capitalExceptionalExpense
     * @return mixed
     */
    private function exceptionalResult($capitalExceptionalOperatingProduct, $capitalExceptionalExpense){
        return $exceptionalResult = $capitalExceptionalExpense + $capitalExceptionalOperatingProduct;
    }

    private function capitalExceptionalOperatingProduct(){
        return $capitalExceptionalOperatingProduct = 0;
        //TODO find calculation
    }


    private function capitalExceptionalExpense(){
        return $capitalExceptionalExpense = 0;
        //TODO find calculation
    }

    private function resultBeforeTax($operatngResult, $financialResult ){
        return $resultBeforeTax =  $operatngResult + $financialResult;
    }

    private function financialResult($totalFinanceExpenses, $totalFinancialProduct){
        return $financialResult = $totalFinanceExpenses + $totalFinancialProduct;
    }

    private function totalFinanceExpenses($intestAndSimilarExpenses){
        return $intestAndSimilarExpenses;
    }

    private function intestAndSimilarExpenses(){
        //TODO
    }

    private function totalFinancialProduct($intestAndSimilarProduct){
        return $intestAndSimilarProduct;
    }

    private function operatingResult($totalOperatingProduct, $totalOperatingExpenses){
        $operatingResult = $totalOperatingProduct - $totalOperatingExpenses;
    }

    private function totalOperatingExpenses(
        $goodsPurchases,
        $changeInStock,
        $purchasesOfRawMaterialsAndSupplies,
        $InventoryChange,
        $otherPurchaseAndExternalCharges,
        $taxesAndSimilarPayement,
        $salariesAndTretments,
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
                $taxesAndSimilarPayement +
                $salariesAndTretments +
                $socialCharges +
                $depreciationAndAmortization +
                $provisions +
                $provisionOnCurrentAsset +
                $provisionForRiskAndCharge +
                $otherExpenses;
    }

    private function provision(){


    }

    public function amortizationProductionLign(){
        //TODO Get array with productLign

        $amortization = 0;
        //TODO GET nombre machine de la société
        $productLigns = [];

        foreach ($productLigns as $productLign ){
            $creatAT = $productLign->getTurnCreation();
            $salesPrice = $productLign->getCreationCost();



        }
        return $amortization;
    }

    public function amortizationFactory(){
        //TODO Get array with factory

        $amortization = 0;
        //TODO GET nombre factory de la société
        $factories = [];

        foreach ($factories as $factory ){
            $creatAT = $factory->getTurnCreation();
            $salesPrice = $factory->getCreationCost();

            //TODO get turn in game entity

        }
        return $amortization;
    }

    private function socialCharges($payRoll, Game $game){

        $employerContributions = $game->getEmployerContributions();
        //TODO add employerContributions in Game Entity

        return $socialCharges = $payRoll*$employerContributions/(1+$employerContributions);
    }

    private function salariesAndTreatments(Socity $socity, Game $game){
        $salariesAndTreatments = 0;
        $payRoll = $this->payRoll($socity);
        $socialCharges = $this->socialCharges($payRoll, $game);
        return $salariesAndTreatments = $payRoll-$socialCharges;
    }

    private function payRoll(Socity $socity){
        $payRoll = 0;
        $employees = $socity->getHumanRessourcies();
        foreach ($employees as $employee){
            $payRoll += $employee->getSalary();
        }
        return $payRoll;
    }

    private function taxesAndSimilarPayement($netTurnover, Game $game, $salariesAndTreatments){
        $taxeTurnover = $game->getTaxTurnOver();
        $payTax = $game->getPayTax();

        return $taxesAndSimilarPayement = $taxeTurnover*$netTurnover + $salariesAndTreatments*$payTax;
    }

    private function otherPurchasesAndExternalCharges(Game $game, $netTurnover){
        $brandAdvertisement = 0; //TODO get brandAdvertisement
        $productAdvertisement =0;//TODO get productAdvertisement
        $quality = 0;//TODO get quality
        $variableExternalCharges = $game->getVariableExternalCharges();

        return $otherPurchasesAndExternalCharges =
            $brandAdvertisement +
            $productAdvertisement +
            $quality +
            $netTurnover*$variableExternalCharges;
    }

    private function inventoryChange(){
        //function not use already in the program
        return $inventoryChange = 0;
    }

    private function purchasesOfRawMaterialsAndSupplies(){
        //TODO
        return $purchasesRawMaterialsAndOtherSupplies = 0;
    }

    private function changeInStock(){
        //TODO
        return $changeInStock = 0;
    }

    private function goodsPurchases(){
        //TODO
        return $goodsPurchases = 0;
    }

    private function netSales($goodsSale, $productionSoldGoods, $productionSoldServices){
        return $netSales = $goodsSale + $productionSoldGoods + $productionSoldServices;
    }
    //TODO ALL FUNCTION IN "produit d'exploitation"


}
