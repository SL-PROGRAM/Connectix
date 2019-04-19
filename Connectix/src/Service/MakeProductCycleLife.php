<?php


namespace App\Service;


use App\Entity\Product;
use App\Entity\ProductLife;

class MakeProductCycleLife
{
    public function makeCycleLife($cyclelifeNumber, Product $product)
    {
        $productCycle = new ProductLife();
        $cycleDuration = round(rand(1, 3));
        $publicityCoeficient = 100; // value change for calculation at the turn end
        $maxProduct = $product->getProductMaxNumber();
        $priceProduct = $product->getSalePrice();



    }

}
