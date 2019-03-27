<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Socity;
use App\Repository\ProductRepository;
use App\Repository\PurchaseOrderRepository;
use App\Repository\ReseachOrderRepository;
use App\Repository\SalesOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PlayerController extends AbstractController
{
    /**
     * @Route("/sales", name="player_sales")
     * @IsGranted("ROLE_USER")
     */
    public function sales(ProductRepository $productRepository,
                          ReseachOrderRepository $reseachOrderRepository,
                          SalesOrderRepository $salesOrderRepository,
                          PurchaseOrderRepository $purchaseOrderRepository)
    {
        $socity = $this->getUser()->getSocity();
        $productPurchasePrint = $this->productPurchasePrint($productRepository, $purchaseOrderRepository, $socity);
        $productSalesPrint = $this->productSalesPrint( $productRepository,
                                        $salesOrderRepository,
                                        $reseachOrderRepository,
                                        $purchaseOrderRepository,
                                        $socity);

        return $this->render('player/sales.html.twig', [
            'controller_name' => 'PlayerSales page',
            "productPurchasePrint" => $productPurchasePrint,
            "productSalesPrint" => $productSalesPrint,
        ]);
    }

    private function productPurchasePrint(ProductRepository $productRepository, PurchaseOrderRepository $purchaseOrderRepository, Socity $socity){

        $productPurchaseOrders = $this->productPurchaseOrders($purchaseOrderRepository, $socity);
        $productPurchables = $this->productPurchables($productRepository);


        return $productPurchasePrint = $this->productPurchase($productPurchables, $productPurchaseOrders);

    }

    private function productPurchables(ProductRepository $productRepository){
        return $productLvl1 = $productRepository->findBy(["technologicLevel" => 1]);
    }


    private function productPurchaseOrders(PurchaseOrderRepository $purchaseOrderRepository, Socity $socity)
    {
        $turn = $this->getUser()->getGame()->getTurn();
         return $productPurchaseOrders = $purchaseOrderRepository->findBy(["socity" => $socity, "turn" => $turn]);

    }



    private function productSalesPrint(ProductRepository $productRepository,
                                       SalesOrderRepository $salesOrderRepository,
                                       ReseachOrderRepository $reseachOrderRepository,
                                       PurchaseOrderRepository $purchaseOrderRepository,
                                       Socity $socity)
    {
        $productSalePrint = [];
        $productSalesOrders = $this->productSalesOrders($salesOrderRepository, $socity);
        $productPurchaseOrders = $this->productPurchaseOrders($purchaseOrderRepository, $socity);
        $productSalable = $this->productSalable( $reseachOrderRepository, $productRepository, $socity);

        dump($productSalable);
        //TODO add differentiation salesType

        foreach ($productSalable as $product){
            $quantityProfessional = 0;
            $quantityParticular = 0;
            $quantity = 0;
            $salesOrderId = null;
            $stock = 0;

            $id = $product->getId();
            $name = $product->getName();
            $salesPrice = $product->getSalePrice();
            $purchaseCost = $this->purchaseCost($product);
            $cycleLife = $product->getProductLifes(); //TODO modify to select productLifeCycle

            foreach ($productPurchaseOrders as $productPurchaseOrder){
                $stock += $productPurchaseOrder->getProductQuantityPurchase();
            }


            foreach ($productSalesOrders as $productSalesOrder) {
                if ($productSalesOrder->getProduct()->getName() === $product->getName()) {
                    $quantity = $productSalesOrder->getProductQuantitySales();
                    $quantityProfessional = $this->quantityProfessional($quantity);
                    $quantityParticular = $this->quantityParticular($quantity);
                    $salesOrderId = $productSalesOrder->getId();
                }
            }
             $productPrint = [
                "id" => $id,
                "name" => $name,
                "salesPrice" => $salesPrice,
                "stock" => $stock,
                 "cycleLife" => $cycleLife,
                 "purchaseCost" => $purchaseCost,
                "quantityProfessional" => $quantityProfessional,
                "quantityParticular" => $quantityParticular,
                "quantity" => $quantity,
                "SalesOrderId" => $salesOrderId,
            ];
            array_push($productSalePrint, $productPrint);

        }
        return $productSalePrint;
    }

    private function quantityProfessional($quantity){
//        $proCoeficient = $this->getUser()->getSocity()->getBalanceSheets()->getProfessionalSalesPart();

//        if($proCoeficient === 0 or $proCoeficient == null){
            $quantityProfessional = $quantity*0.5;
//        }
//        else{
//            $quantityProfessional = $quantity*$proCoeficient;
//        }

        return $quantityProfessional;
    }

    private function quantityParticular($quantity){
//        $proCoeficient = $this->getUser()->getSocity()->getBalanceSheets()->getParticularSalesPart();

//        if($proCoeficient === 0 or $proCoeficient == null){
            $quantityParticular = $quantity*0.5;
//        }
//        else{
//            $quantityParticular = $quantity*$proCoeficient;
//        }

        return $quantityParticular;
    }

    private function purchaseCost($product){
            if ($product->getTechnologicLevel() === 1){
                return $product->getBuyPrice();
            }
            else{
                return 100;
                //TODO change value by calculation
            }
    }

    private function productSalesOrders(SalesOrderRepository $salesOrderRepository, Socity $socity)
    {
        $turn = $this->getUser()->getGame()->getTurn();
        return $productPurchaseOrders = $salesOrderRepository->findBy(["socity" => $socity, "turn" => $turn]);
    }


    private function productResearchOrder($Product, ReseachOrderRepository $reseachOrderRepository, Socity $socity){
        return $productReseachOrders = $reseachOrderRepository->findBy(["socity" => $socity, "product" => $Product]);
    }



    private function productPurchase($productPurchables, $productPurchaseOrders){
        $productPurchasePrint =  [];
        foreach ($productPurchables as $productPurchable){
            $quantity = 0;
            $PurchaseOrderId = null;
            $id = $productPurchable->getId();
            $name = $productPurchable->getName();
            $purchasePrice = $productPurchable->getBuyPrice();
            $quantityDiscount = $productPurchable->getQuantityDiscount();
            foreach ($productPurchaseOrders as $productPurchaseOrder){
                if($productPurchaseOrder->getProduct()->getName() === $productPurchable->getName()){
                    $quantity = $productPurchaseOrder->getProductQuantityPurchase();
                    $PurchaseOrderId = $productPurchaseOrder->getId();
                }
            }
            $productPrint = [
                "id" => $id,
                "name" => $name,
                "purchasePrice" => $purchasePrice,
                "quantityDiscount" => $quantityDiscount,
                "quantity" => $quantity,
                "PurchaseOrderId" => $PurchaseOrderId,
            ];
            array_push($productPurchasePrint, $productPrint);
        }
        return $productPurchasePrint;
    }











    /**
     * @Route("/publicity", name="player_publicity")
     */
    public function publicity()
    {



        return $this->render('player/publicity.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }


    private function productSalable (ReseachOrderRepository $reseachOrderRepository,ProductRepository $productRepository, Socity $socity ){
        $productSalable = [];
        $products = $productRepository->findAll();
        foreach ($products as $product){
            $research = 0;
            $productResearchOrders = $this->productResearchOrder($product, $reseachOrderRepository, $socity);
            foreach ($productResearchOrders as $productResearchOrder){
                $research += $productResearchOrder->getReseachDo();
            }


            if($research >= $product->getResearchCost() or $product->getTechnologicLevel() === 1 ){
                array_push($productSalable, $product);
            }
        }
        return $productSalable;
    }


    /**
     * @Route("/production", name="player_production")
     */
    public function production()
    {



        return $this->render('player/production.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    /**
     * @Route("/human", name="player_human_ressourcies")
     */
    public function humanRessources()
    {



        return $this->render('player/human.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    /**
     * @Route("/financial", name="player_financial")
     */
    public function financial()
    {



        return $this->render('player/financial.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    /**
     * @Route("/information", name="player_information")
     */
    public function information()
    {



        return $this->render('player/information.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }




}
