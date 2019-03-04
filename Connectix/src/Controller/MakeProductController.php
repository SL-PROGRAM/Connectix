<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductLife;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class MakeProductController extends AbstractController
{


    public function makeProduct(){

        $entityManager = $this->getDoctrine()->getManager();

        /*
         * Definition number of product create
         */
        $nbProduct = 16;

        /*
         * Definition type product buy a letter
         */
        $name = 'A';


        for ($i=0; $i<$nbProduct; $i++){
            $product = new Product();


            /*
             * creation of base product
             */
            if ($i < 4){

                $nameNumber = $i%4 +1;
                $salePrice = round(rand(1500, 2500));
                $buyPrice = $salePrice*round((rand(70,90)/100),2);

                $productionActivityCost = $buyPrice/10 +round(rand(0, 10));
                $technologicLevel = 1;
                $reseachCost = 0;
                $productMaxNumber = round(rand(100000, 200000),-3);
                $quantityDiscount = $productMaxNumber/100;
                $productAlreadySales = 0;
                $priceDiscount = 5; // use in percent
                $productSaleType = 1;



                /*
                 * set the product
                 */
                $product    ->setName('Product ' .$name .$nameNumber)
                            ->setTechnologicLevel($technologicLevel)
                            ->setBuyPrice($buyPrice)
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

                for ($j = 1 ; $j < 5 ; $j++){
                    $cycleLife = $this-> makeCycleLife($j, $product);
                    $product ->addProductLife($cycleLife);
                }



                $entityManager  ->persist($product);
                $entityManager  ->flush();

            }

            $name++;
        }





    }

    public function makeCycleLife($cyclelifeNumber,Product $product){

        $productCycle = new ProductLife();
        $cycleDuration = round(rand(1, 2));


    /*
     * Define First lifeProduct
     */
        //if($cyclelifeNumber === 1){


            $maxProduct = $product->getProductMaxNumber();
            $priceProduct = $product->getBuyPrice();
            $productCycleMaxNumber = $maxProduct*round((rand(20,45)/100),2);

            $priceCoeficient = 20;

            $minPublicityImpact = $priceProduct*10;
            $maxPublicityImpact = $priceProduct*50;
            $publicityCoeficient = 1; // value change for calculation at the turn end

            $quality = round(rand(90,100));

        //}


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
       // $entityManager->flush();

        return $productCycle;
    }


    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        $this->makeProduct();


        return $this->render('make_product/index.html.twig', [
            'controller_name' => 'MakeProductController',
        ]);
    }
}
