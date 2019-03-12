<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 05/03/19
 * Time: 13:27
 */

namespace App\Controller;


use App\Entity\Game;
use App\Entity\Product;

/**
 * Class FonctionWaiting
 * @package App\Controller
 * @see fonction create but not use already in the software
 */
class FonctionWaiting
{

    /**
     * @param Product $product
     * @param $totalPublicity
     * @return float|int
     */
    public function publicityCoeficient(Product $product, $totalPublicity, Game $game){
        $publicityCoefficient = 100;

        $productLife = $this->getCycleLifeProductToUse($game, $product);

        $PriceMinPublicityImpact = $productLife->getPriceMinPublicityImpact();
        $PriceMaxPublicityImpact = $productLife->getPriceMaxPublicityImpact();
        $publicityCoefficientMax = $productLife->getPublicityCoeficient();

        if ($totalPublicity >= $PriceMaxPublicityImpact){
            $totalPublicity = $PriceMaxPublicityImpact;
        }

        if ($totalPublicity <= $PriceMinPublicityImpact){
            $publicityCoefficient = 1;
        }

        if ($totalPublicity < $PriceMaxPublicityImpact and $totalPublicity >= $PriceMinPublicityImpact ){
            $publicityCoefficient = round(100*$totalPublicity*$publicityCoefficientMax/$PriceMaxPublicityImpact);
        }

        return $publicityCoefficient;
    }

    /**
     * @param Game $game
     * @param Product $product
     * @return ProductLife|mixed
     */
    function getCycleLifeProductToUse(Game $game, Product $product){

        $gameTurn = $game->getTurn();

        $productAlreadySales = $product->getProductAlreadySales();
        $productlifes = $product->getProductLifes();

        foreach ($productlifes as $productLife){
            $productCycleLifeNumberMax =$productLife->getProductCycleLifeNumberMax();
            $cycleDuration = $productLife->getCycleDuration();


            if($productCycleLifeNumberMax > $productAlreadySales and $gameTurn <= $cycleDuration){
                return $productLife;
            }
        }

    }



    //general financial calc

    /**
     * @param $borrowedAmount
     * @param $annualInterestRate
     * @param $termOfLoan
     * @param $deferredFormLoan
     * @return float|int
     */
    function totalLoanCost($borrowedAmount, $annualInterestRate, $termOfLoan, $deferredFormLoan ){
        return $totalCost = $borrowedAmount*$annualInterestRate*($termOfLoan+$deferredFormLoan);
    }


    /**
     * @param $borrowedAmount
     * @param $monthlyDueDate
     * @param $annualInterestRate
     * @return float|int
     */
   function loanDuration($borrowedAmount, $monthlyDueDate, $annualInterestRate){
            $loanDuration = 0;
        while($borrowedAmount*-$annualInterestRate > (12*$monthlyDueDate) ){
            $loanDuration += 12;
            $borrowedAmount -= ($borrowedAmount*$annualInterestRate) - (12*$monthlyDueDate);
        }
            $loanDuration += ceil(($borrowedAmount*$annualInterestRate)/($monthlyDueDate));
            return $loanDuration;
   }



















    // financial monthly calc

    /**
     * @param $borrowedAmount
     * @param $annualInterestRate
     * @param $termOfLoan
     * @param int $deferredFormLoan
     * @return float|int
     */
    function monthlyInterestRateCost($borrowedAmount, $annualInterestRate, $termOfLoan, $deferredFormLoan = 0){
            return ($borrowedAmount*($annualInterestRate/12)*($termOfLoan+$deferredFormLoan)/100);
    }


    /**
     * @param $borrowedAmount
     * @param $dueDate
     * @param $annualInterestRate
     * @param $termOfLoan
     * @param int $deferredFormLoan
     * @return float|int
     */
    function monthlyBorrowedAmountRemain($borrowedAmount, $dueDate, $annualInterestRate, $termOfLoan, $deferredFormLoan = 0 ){
        return $monthlyBorrowedAmountRemain = $borrowedAmount -
            ($dueDate -
                $this->monthlyInterestRateCost(
                    $borrowedAmount,
                    $annualInterestRate,
                    $termOfLoan,
                    $deferredFormLoan)
            );
    }

    /**
     * @param $borrowedAmount
     * @param $annualInterestRate
     * @param $termOfLoan
     * @param $deferredFormLoan
     * @return float|int
     */
    function monthlyDueDate($borrowedAmount, $annualInterestRate, $termOfLoan, $deferredFormLoan){
        return $monthlyDueDate =
            (
                $borrowedAmount +
                $this->totalLoanCost($borrowedAmount, $annualInterestRate, $termOfLoan, $deferredFormLoan)
            )/(
                $termOfLoan + $deferredFormLoan
            ) /12;
    }

    // financial annual calc

    /**
     * @param $borrowedAmount
     * @param $annualInterestRate
     * @param $termOfLoan
     * @param int $deferredFormLoan
     * @return float|int
     */
    function AnnuallyInterestRateCost($borrowedAmount, $annualInterestRate, $termOfLoan, $deferredFormLoan = 0){
        return ($borrowedAmount*($annualInterestRate)*($termOfLoan+$deferredFormLoan)/100);
    }

    /**
     * @param $borrowedAmount
     * @param $annualInterestRate
     * @param $termOfLoan
     * @param $deferredFormLoan
     * @return float|int
     */
    function annuallyDueDate($borrowedAmount, $annualInterestRate, $termOfLoan, $deferredFormLoan){
        return $monthlyDueDate =
            (
                $borrowedAmount +
                $this->totalLoanCost($borrowedAmount, $annualInterestRate, $termOfLoan, $deferredFormLoan)
            )/(
                $termOfLoan + $deferredFormLoan
            );
    }

    /**
     * @param $borrowedAmount
     * @param $dueDate
     * @param $annualInterestRate
     * @param $termOfLoan
     * @param int $deferredFormLoan
     * @return float|int
     */
    function annualyBorrowedAmountRemain($borrowedAmount, $dueDate, $annualInterestRate, $termOfLoan, $deferredFormLoan = 0 ){
        return $monthlyBorrowedAmountRemain = $borrowedAmount -
            ($dueDate -
                $this->annuallyInterestRateCost(
                    $borrowedAmount,
                    $annualInterestRate,
                    $termOfLoan,
                    $deferredFormLoan)
            );
    }


    /**
     * @param int $quantityProduct
     * @param int $salesPriceProduct
     * @return float|int
     */
    function annualSalesProduct (int $quantityProduct,int $salesPriceProduct){
        return $annualSalesProduct = $quantityProduct*$salesPriceProduct;
    }

    /**
     * @param array $annualSalesProduct
     * @return int|mixed
     */
    function annualSales(array $annualSalesProduct){
            $annualSales = 0;
        foreach ($annualSalesProduct as $value){
            $annualSales += $value;
        }
            return $annualSales;
    }



}
