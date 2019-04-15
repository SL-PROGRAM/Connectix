<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Entity\Product;
use App\Entity\ProductLife;
use App\Entity\Socity;
use App\Entity\User;
use App\Form\GameType;
use App\Form\SocityType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MakeGameController extends AbstractController
{
    /**
     * @Route("/admin/makegame", name="admin_make_game")
     */
    public function index(Request $request): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            return    $this->makeGame($game, $request);

//                $this->redirectToRoute('game_index');
        }

        return $this->render('game/new.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
            'value' => 'Game'
        ]);
    }

    private function makeGame(Game $game, Request $request){

            $socity = new Socity();
            $user1 = new User();
            $user1->setFirstName('Joueur1');
            $socity->getTags()->add($user1);
            $user2 = new User();
            $user2->setFirstName('Joueur2');
            $user3 = new User();
            $user3->setFirstName('Joueur3');
            $user4 = new User();
            $user4->setFirstName('Joueur4');
            $user5 = new User();
            $user5->setFirstName('Joueur5');
            $user6 = new User();
            $user6->setFirstName('Joueur6');


            $form = $this->createForm(SocityType::class, $socity);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($socity);
                $entityManager->flush();


                return $this->makeSocity($socity, $request);

            }

            return $this->render('game/new.html.twig', [
                'game' => $socity,
                'form' => $form->createView(),
                'value' => 'Socity'

            ]);

    }

    private function makeSocity(Socity $socity, Request $request){

            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return true;
            }

            return $this->render('game/new.html.twig', [
                'game' => $user,
                'form' => $form->createView(),
                'value' => 'Player'

            ]);
    }

//    private function makeProduct()    {
//        $entityManager = $this->getDoctrine()->getManager();
//
//        /*
//         * Definition number of product create
//         */
//        $nbProduct = 16;
//
//        /*
//         * Definition type product buy a letter
//         */
//        $name = 'A';
//
//
//        for ($i=0; $i<$nbProduct; $i++) {
//            $product = new Product();
//
//
//            $productAlreadySales = 0;
//            $priceDiscount = 95;
//
//            /*
//             * creation of base product
//             */
//            if ($i < 4) {
//                $nameNumber = 1;
//                $salePrice = round(rand(1500, 1900));
//                $buyPrice = $salePrice * round((rand(70, 90) / 100), 2);
//
//                $productionActivityCost = $buyPrice / 10 + round(rand(0, 10));
//                $technologicLevel = 1;
//                $reseachCost = 0;
//                $productMaxNumber = round(rand(100000, 200000), -3);
//                $quantityDiscount = $productMaxNumber / 100;
//                $productSaleType = 1;
//
//                $product->setBuyPrice($buyPrice);
//            } elseif ($i < 8) {
//                if ($i === 4) {
//                    $name = 'A';
//                }
//
//                $nameNumber = 2;
//                $salePrice = round(rand(2000, 2400));
//                $productionActivityCost = $salePrice / 10 + round(rand(0, 10));
//                $technologicLevel = 2;
//                $reseachCost = 1000;
//                $productMaxNumber = round(rand(100000, 200000), -3);
//                $quantityDiscount = $productMaxNumber / 100;
//                $productSaleType = 1;
//            } elseif ($i < 12) {
//                if ($i === 8) {
//                    $name = 'A';
//                }
//                $nameNumber = 3;
//                $salePrice = round(rand(2500, 3200));
//                $productionActivityCost = $salePrice / 10 + round(rand(0, 10));
//                $technologicLevel = 3;
//                $reseachCost = 1000;
//                $productMaxNumber = round(rand(100000, 200000), -3);
//                $quantityDiscount = $productMaxNumber / 100;
//                $productSaleType = 1;
//            } elseif ($i < 16) {
//                if ($i === 12) {
//                    $name = 'A';
//                }
//
//                $nameNumber = 4;
//                $salePrice = round(rand(3500, 5000));
//                $productionActivityCost = $salePrice / 10 + round(rand(0, 10));
//                $technologicLevel = 4;
//                $reseachCost = 1000;
//                $productMaxNumber = round(rand(100000, 200000), -3);
//                $quantityDiscount = $productMaxNumber / 100;
//                $productSaleType = 1;
//            }
//
//
//            /*
//             * set the product
//             */
//            $product    ->setName('Product ' .$name .$nameNumber)
//                ->setTechnologicLevel($technologicLevel)
//                ->setSalePrice($salePrice)
//                ->setQuantityDiscount($quantityDiscount)
//                ->setProductiorActivityCost($productionActivityCost)
//                ->setResearchCost($reseachCost)
//                ->setProductMaxNumber($productMaxNumber)
//                ->setPriceDiscount($priceDiscount)
//                ->setProductAlreadySales($productAlreadySales)
//                ->setProductSaleType($productSaleType);
//
//            /*
//             * creation of cycleLife for the product
//             */
//
//            for ($j = 1 ; $j < 5 ; $j++) {
//                $cycleLife = $this-> makeCycleLife($j, $product);
//                $product ->addProductLife($cycleLife);
//            }
//            $entityManager  ->persist($product);
//            $entityManager  ->flush();
//            $name++;
//        }
//    }
//
//    /**
//     * @param $cyclelifeNumber
//     * @param Product $product
//     * @return ProductLife
//     */
//    public function makeCycleLife($cyclelifeNumber, Product $product)
//    {
//        $productCycle = new ProductLife();
//        $cycleDuration = round(rand(1, 3));
//        $publicityCoeficient = 100; // value change for calculation at the turn end
//        $maxProduct = $product->getProductMaxNumber();
//        $priceProduct = $product->getSalePrice();
//
//
//        /*
//         * Define First lifeProduct
//         */
//        if ($cyclelifeNumber === 1) {
//            $productCycleMaxNumber = $maxProduct*round((rand(25, 45)/100), 2);
//            $priceCoeficient = 130;
//            $minPublicityImpact = $priceProduct*10;
//            $maxPublicityImpact = $priceProduct*40;
//            $quality = round(rand(95, 99));
//        }
//
//        if ($cyclelifeNumber === 2) {
//            $cycleDuration = $this->getCycleduration($product, $cyclelifeNumber, $cycleDuration);
//
//            $productCycleMaxNumber = $maxProduct*round((rand(45, 60)/100), 2);
//            $priceCoeficient = 120;
//            $minPublicityImpact = $priceProduct*15;
//            $maxPublicityImpact = $priceProduct*50;
//            $quality = round(rand(97, 100));
//        }
//
//        if ($cyclelifeNumber === 3) {
//            $cycleDuration = $this->getCycleduration($product, $cyclelifeNumber, $cycleDuration);
//
//            $productCycleMaxNumber = $maxProduct*round((rand(60, 90)/100), 2);
//            $priceCoeficient = 110;
//            $minPublicityImpact = $priceProduct*15;
//            $maxPublicityImpact = $priceProduct*60;
//            $quality = round(rand(98, 100));
//        }
//
//        if ($cyclelifeNumber === 4) {
//            $cycleDuration = $this->getCycleduration($product, $cyclelifeNumber, $cycleDuration);
//
//            $productCycleMaxNumber = $maxProduct;
//            $priceCoeficient = 100;
//            $minPublicityImpact = $priceProduct*20;
//            $maxPublicityImpact = $priceProduct*70;
//            $quality = round(rand(97, 99));
//        }
//
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $productCycle   ->setCycleLifeNumber($cyclelifeNumber)
//            ->setCycleDuration($cycleDuration)
//            ->setProductCycleLifeNumberMax($productCycleMaxNumber)
//            ->setPriceCoeficient($priceCoeficient)
//            ->setPublicityCoeficient($publicityCoeficient)
//            ->setPriceMinPublicityImpact($minPublicityImpact)
//            ->setPriceMaxPublicityImpact($maxPublicityImpact)
//            ->setQuality($quality);
//        $entityManager->persist($productCycle);
//
//        return $productCycle;
//    }
//
//
//
//    /**
//     * @param Product $product
//     * @param $cycleLifeNumber
//     * @param $cycleDuration
//     * @return int|null
//     */
//    public function getCycleDuration(Product $product, $cycleLifeNumber, $cycleDuration)
//    {
//        $cycleLifeNumber = $cycleLifeNumber-1;
//
//        $productLifes = $product->getProductLifes();
//        foreach ($productLifes as $productlife) {
//            if ($cycleLifeNumber === $productlife->getCycleLifeNumber()) {
//                $cycleDuration += $productlife->getCycleDuration();
//            };
//        }
//
//        return $cycleDuration;
//    }

    private function makeProductLife(){

    }



    private function makeUser(){


    }

    private function makeBalance_sheet(){

    }



}
