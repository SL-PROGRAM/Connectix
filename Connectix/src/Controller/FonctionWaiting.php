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

}
