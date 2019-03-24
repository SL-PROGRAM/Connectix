<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CashFlowController extends AbstractController
{
    /**
     * @Route("/cashflow", name="cash_flow")
     */
    public function index()
    {
        return $this->render('cash_flow/index.html.twig', [
            'controller_name' => 'CashFlowController',
        ]);
    }


    private function monthlyValue(Game $game){
        //VAT CALCULATION
        $monthlyRowMaterialPurchase = 0;
        $monthlyMerchandisePurchase = 0;
        $monthlyBillingProductSales = 0;
        $monthlyOtherCharge = 0;
        $monthlyImmobilization = 0;

        //CASH INCLUDES TTC
        $cashingSales = 0;
        $capitalContribution = 0;
        $mediumAndLongLoan = 0;
        $discountBillOfExchange = 0;
        $transferOfCapital = 0;

        //DISBURSEMENTS TTC
        $externalCharges = 0;
        $dueAndTaxes = 0;
        $personnelCost = 0;
        $financialExpenses = 0;
        $tangibleInvestments = 0;
        $repaymentOfLoan = 0;



    }

    private function cashingSales(){

    }

    private function monthlyCaluclation(){

    }



    //TODO validation $vatCredit
    private function totalCashInclude($cashingSales,
                                      $vatCredit,
                                      $capitalContribution,
                                      $mediumAndLongLoan,
                                      $discountBillOfExchange,
                                      $transferOfCapital){

        return $totalCashInclude =    $cashingSales+
                                      $vatCredit+
                                      $capitalContribution+
                                      $mediumAndLongLoan+
                                      $discountBillOfExchange+
                                      $transferOfCapital;
    }

    private function totalDisbursement($monthlyRowMaterialTTCPurchase,
                                      $monthlyMerchandiseTTCPurchase,
                                      $externalCharges,
                                      $dueAndTaxes,
                                      $personnelCost,
                                      $financialExpenses,
                                      $VatToPay,
                                      $tangibleInvestments,
                                      $repaymentOfLoan){

        return $totalDisbursement =       $monthlyRowMaterialTTCPurchase+
                                          $monthlyMerchandiseTTCPurchase+
                                          $externalCharges+
                                          $dueAndTaxes+
                                          $personnelCost+
                                          $financialExpenses+
                                          $VatToPay+
                                          $tangibleInvestments+
                                          $repaymentOfLoan;


    }


    private function balanceOfTheMonth($totalCashInclude, $totalDibursement){
        return $balanceOfTheMonth = $totalCashInclude + $totalDibursement;
    }

    private function balanceEndOfMonth($balanceOfTheMonth){
        //TODO ADD balanceEndOfMonth of LAST MONTH
        return $balanceEndOfMonth = $balanceOfTheMonth;
    }






    //Function use to calcul VAT

    private function monthlyVATCalculation(Game $game,
                                           $monthlyRowMaterialPurchase,
                                           $monthlyMerchandisePurchase,
                                           $monthlyBillingProductSales,
                                           $monthlyOtherCharge,
                                           $monthlyImmobilization){
        //TODO CHANGE POSITION OF INCOMING VALUE

        $monthlyCollectedVAT = $this->monthlyCollectedVAT($monthlyBillingProductSales, $game);
        $monthlyHTPurchase = $this->monthlyHTPurchase($monthlyBillingProductSales,$game);
        $monthlyRowMaterialTTCPurchase = $this->monthlyTTCPurchase($monthlyRowMaterialPurchase, $game);
        $monthlyDeductibleVATOnRowMaterial = $this->monthlyDeductibleVATOnRowMaterial($monthlyRowMaterialPurchase, $game);
        $monthlyDeductibleVATOnMerchandise = $this->monthlyDeductibleVATOnMerchandise($monthlyMerchandisePurchase, $game);
        $monthlyDeductibleVATOnOtherCharge = $this->monthlyDeductibleVATOnOtherCharge($monthlyOtherCharge, $game);
        $monthlyDeductibleVATOnImmobilization = $this->monthlyDeductibleVATOnImmobilization($monthlyImmobilization, $game);
        $monthlyDeductibleVAT = $this->monthlyDeductibleVAT($monthlyDeductibleVATOnImmobilization,
                                                            $monthlyDeductibleVATOnOtherCharge,
                                                            $monthlyDeductibleVATOnMerchandise,
                                                            $monthlyDeductibleVATOnRowMaterial);
        $vatCredit = $this->vatCredit($monthlyCollectedVAT, $monthlyDeductibleVAT );
        $vatToPay = $this->vatToPay($monthlyCollectedVAT, $monthlyDeductibleVAT );
    }

    /**
     * @param $monthlyBillingProductSales
     * @param Game $game
     * @return float|int
     */
    private function monthlyCollectedVAT($monthlyBillingProductSales,Game $game){
        return $monthlyCollectedVAT = $monthlyBillingProductSales/100*$game->getTva();
    }

    /**
     * @param $monthlyBillingProductSales
     * @param Game $game
     * @return float|int
     */
    private function monthlyHTPurchase($monthlyBillingProductSales,Game $game){
        return $htSales = $monthlyBillingProductSales/(100 - $game->getTva());
    }


    /**
     * @param $monthlyRowMaterialPurchase
     * @param Game $game
     * @return float|int
     */
    private function monthlyTTCPurchase($monthlyRowMaterialPurchase, Game $game){
        return $monthlyTTCPurchase = $monthlyRowMaterialPurchase + ($monthlyRowMaterialPurchase/100 * $game->getTva());
    }

    /**
     * @param $monthlyRowMaterialPurchase
     * @param Game $game
     * @return float|int
     */
    private function monthlyDeductibleVATOnRowMaterial($monthlyRowMaterialPurchase, Game $game){
        return $monthlyDeductibleVATOnRowMaterial = $monthlyRowMaterialPurchase/100 * $game->getTva();
    }

    /**
     * @param $monthlyMerchandisePurchase
     * @param Game $game
     * @return float|int
     */
    private function monthlyDeductibleVATOnMerchandise($monthlyMerchandisePurchase, Game $game){
        return $monthlyDeductibleVATOnMerchandise = $monthlyMerchandisePurchase/100 * $game->getTva();
    }

    /**
     * @param $monthlyOtherCharge
     * @param Game $game
     * @return float|int
     */
    private function monthlyDeductibleVATOnOtherCharge($monthlyOtherCharge, Game $game){
        return $monthlyDeductibleVATOnOtherCharge = $monthlyOtherCharge/100 * $game->getTva();
    }

    /**
     * @param $monthlyImmobilization
     * @param Game $game
     * @return float|int
     */
    private function monthlyDeductibleVATOnImmobilization($monthlyImmobilization, Game $game){
        return $monthlyDeductibleVATOnImmobilization = $monthlyImmobilization/100 * $game->getTva();

    }

    /**
     * @param $monthlyDeductibleVATOnImmobilization
     * @param $monthlyDeductibleVATOnOtherCharge
     * @param $monthlyDeductibleVATOnMerchandise
     * @param $monthlyDeductibleVATOnRowMaterial
     * @return mixed
     */
    private function monthlyDeductibleVAT($monthlyDeductibleVATOnImmobilization,
                                          $monthlyDeductibleVATOnOtherCharge,
                                          $monthlyDeductibleVATOnMerchandise,
                                          $monthlyDeductibleVATOnRowMaterial){

        return $monthlyDeductibleVAT =    $monthlyDeductibleVATOnImmobilization+
                                          $monthlyDeductibleVATOnOtherCharge+
                                          $monthlyDeductibleVATOnMerchandise+
                                          $monthlyDeductibleVATOnRowMaterial;
    }

    /**
     * @param $monthlyCollectedVAT
     * @param $monthlyDeductibleVAT
     * @return int
     */
    private function vatCredit($monthlyCollectedVAT, $monthlyDeductibleVAT ){
        $vatCredit = $monthlyCollectedVAT - $monthlyDeductibleVAT;
        if($vatCredit > 0){
            return $vatCredit;
        }
        else{
            return 0;
        }
    }

    /**
     * @param $monthlyCollectedVAT
     * @param $monthlyDeductibleVAT
     * @return int
     */
    private function vatToPay($monthlyCollectedVAT, $monthlyDeductibleVAT ){
        $vatCredit = $monthlyCollectedVAT - $monthlyDeductibleVAT;
        if($vatCredit > 0){
            return 0;
        }
        else{
            return $vatCredit;
        }
    }
}
