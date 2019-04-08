<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Product;
use App\Entity\ProductLife;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MakeProductController extends AbstractController
{


    /**
     * @Route("/productGenerate", name="product")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $this->makeProduct();


        return $this->render('make_product/index.html.twig', [
            'controller_name' => 'MakeProductController',
        ]);
    }


    public function makeProduct()
    {
        $entityManager = $this->getDoctrine()->getManager();

        /*
         * Definition number of product create
         */
        $nbProduct = 16;

        /*
         * Definition type product buy a letter
         */
        $name = 'A';


        for ($i=0; $i<$nbProduct; $i++) {
            $product = new Product();


            $productAlreadySales = 0;
            $priceDiscount = 95;

            /*
             * creation of base product
             */
            if ($i < 4) {
                $nameNumber = 1;
                $salePrice = round(rand(1500, 1900));
                $buyPrice = $salePrice * round((rand(70, 90) / 100), 2);

                $productionActivityCost = $buyPrice / 10 + round(rand(0, 10));
                $technologicLevel = 1;
                $reseachCost = 0;
                $productMaxNumber = round(rand(100000, 200000), -3);
                $quantityDiscount = $productMaxNumber / 100;
                $productSaleType = 1;

                $product->setBuyPrice($buyPrice);
            } elseif ($i < 8) {
                if ($i === 4) {
                    $name = 'A';
                }

                $nameNumber = 2;
                $salePrice = round(rand(2000, 2400));
                $productionActivityCost = $salePrice / 10 + round(rand(0, 10));
                $technologicLevel = 2;
                $reseachCost = 1000;
                $productMaxNumber = round(rand(100000, 200000), -3);
                $quantityDiscount = $productMaxNumber / 100;
                $productSaleType = 1;
            } elseif ($i < 12) {
                if ($i === 8) {
                    $name = 'A';
                }
                $nameNumber = 3;
                $salePrice = round(rand(2500, 3200));
                $productionActivityCost = $salePrice / 10 + round(rand(0, 10));
                $technologicLevel = 3;
                $reseachCost = 1000;
                $productMaxNumber = round(rand(100000, 200000), -3);
                $quantityDiscount = $productMaxNumber / 100;
                $productSaleType = 1;
            } elseif ($i < 16) {
                if ($i === 12) {
                    $name = 'A';
                }

                $nameNumber = 4;
                $salePrice = round(rand(3500, 5000));
                $productionActivityCost = $salePrice / 10 + round(rand(0, 10));
                $technologicLevel = 4;
                $reseachCost = 1000;
                $productMaxNumber = round(rand(100000, 200000), -3);
                $quantityDiscount = $productMaxNumber / 100;
                $productSaleType = 1;
            }


            /*
             * set the product
             */
            $product    ->setName('Product ' .$name .$nameNumber)
                            ->setTechnologicLevel($technologicLevel)
                            ->setSalePrice($salePrice)
                            ->setQuantityDiscount($quantityDiscount)
                            ->setProductiorActivityCost($productionActivityCost)
                            ->setResearchCost($reseachCost)
                            ->setProductMaxNumber($productMaxNumber)
                            ->setPriceDiscount($priceDiscount)
                            ->setProductAlreadySales($productAlreadySales)
                            ->setProductSaleType($productSaleType);

            /*
             * creation of cycleLife for the product
             */

            for ($j = 1 ; $j < 5 ; $j++) {
                $cycleLife = $this-> makeCycleLife($j, $product);
                $product ->addProductLife($cycleLife);
            }
            $entityManager  ->persist($product);
            $entityManager  ->flush();
            $name++;
        }
    }

    /**
     * @param $cyclelifeNumber
     * @param Product $product
     * @return ProductLife
     */
    public function makeCycleLife($cyclelifeNumber, Product $product)
    {
        $productCycle = new ProductLife();
        $cycleDuration = round(rand(1, 3));
        $publicityCoeficient = 100; // value change for calculation at the turn end
        $maxProduct = $product->getProductMaxNumber();
        $priceProduct = $product->getSalePrice();


        /*
         * Define First lifeProduct
         */
        if ($cyclelifeNumber === 1) {
            $productCycleMaxNumber = $maxProduct*round((rand(25, 45)/100), 2);
            $priceCoeficient = 130;
            $minPublicityImpact = $priceProduct*10;
            $maxPublicityImpact = $priceProduct*40;
            $quality = round(rand(95, 99));
        }

        if ($cyclelifeNumber === 2) {
            $cycleDuration = $this->getCycleduration($product, $cyclelifeNumber, $cycleDuration);

            $productCycleMaxNumber = $maxProduct*round((rand(45, 60)/100), 2);
            $priceCoeficient = 120;
            $minPublicityImpact = $priceProduct*15;
            $maxPublicityImpact = $priceProduct*50;
            $quality = round(rand(97, 100));
        }

        if ($cyclelifeNumber === 3) {
            $cycleDuration = $this->getCycleduration($product, $cyclelifeNumber, $cycleDuration);

            $productCycleMaxNumber = $maxProduct*round((rand(60, 90)/100), 2);
            $priceCoeficient = 110;
            $minPublicityImpact = $priceProduct*15;
            $maxPublicityImpact = $priceProduct*60;
            $quality = round(rand(98, 100));
        }

        if ($cyclelifeNumber === 4) {
            $cycleDuration = $this->getCycleduration($product, $cyclelifeNumber, $cycleDuration);

            $productCycleMaxNumber = $maxProduct;
            $priceCoeficient = 100;
            $minPublicityImpact = $priceProduct*20;
            $maxPublicityImpact = $priceProduct*70;
            $quality = round(rand(97, 99));
        }

        $entityManager = $this->getDoctrine()->getManager();

        $productCycle   ->setCycleLifeNumber($cyclelifeNumber)
                        ->setCycleDuration($cycleDuration)
                        ->setProductCycleLifeNumberMax($productCycleMaxNumber)
                        ->setPriceCoeficient($priceCoeficient)
                        ->setPublicityCoeficient($publicityCoeficient)
                        ->setPriceMinPublicityImpact($minPublicityImpact)
                        ->setPriceMaxPublicityImpact($maxPublicityImpact)
                        ->setQuality($quality);
        $entityManager->persist($productCycle);

        return $productCycle;
    }



    /**
     * @param Product $product
     * @param $cycleLifeNumber
     * @param $cycleDuration
     * @return int|null
     */
    public function getCycleDuration(Product $product, $cycleLifeNumber, $cycleDuration)
    {
        $cycleLifeNumber = $cycleLifeNumber-1;

        $productLifes = $product->getProductLifes();
        foreach ($productLifes as $productlife) {
            if ($cycleLifeNumber === $productlife->getCycleLifeNumber()) {
                $cycleDuration += $productlife->getCycleDuration();
            };
        }

        return $cycleDuration;
    }
}
