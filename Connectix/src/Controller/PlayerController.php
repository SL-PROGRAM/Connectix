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

        $productPurchables = $this->productPurchables($productRepository);

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
        $productPurchasePrint = [];
        $productPurchaseOrders = $this->productPurchaseOrders($purchaseOrderRepository, $socity);
        $productPurchables = $this->productPurchables($productRepository);


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

        $products = $productRepository->findAll();


        //TODO add differentiation salesType

        foreach ($products as $product){
            $quantity = 0;
            $salesOrderId = null;
            $research = 0;
            $stock = 0;
            $productResearchOrders = $this->productResearchOrder($product, $reseachOrderRepository, $socity);
            foreach ($productResearchOrders as $productResearchOrder){
                $research += $productResearchOrder->getReseachDo();
            }
            if($research >= $product->getResearchCost() or $product->getTechnologicLevel() === 1 ){
                $id = $product->getId();
                $name = $product->getName();
                $salesPrice = $product->getSalePrice();
                $purchaseCost = $this->purchaseCost($products);
                $cycleLife = $product->getProductLifes();
                foreach ($productPurchaseOrders as $productPurchaseOrder){
                    $stock += $productPurchaseOrder->getProductQuantityPurchase();
                }
                foreach ($productSalesOrders as $productSalesOrder){
                    if($productSalesOrder->getProduct()->getName() === $product->getName()){
                        $quantity = $productSalesOrder->getProductQuantitySales();
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
                "quantity" => $quantity,
                "SalesOrderId" => $salesOrderId,
            ];
            array_push($productSalePrint, $productPrint);
            }
        }
        return $productSalePrint;
    }

    private function purchaseCost($products){
        foreach ($products as $product){
            if ($product->getTechnologicLevel() === 1){
                return $product->getBuyPrice();
            }
            else{
                return 100;
                //TODO change value by calculation
            }
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















    /**
     * @Route("/publicity", name="player_publicity")
     */
    public function publicity()
    {



        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    /**
     * @Route("/production", name="player_production")
     */
    public function production()
    {



        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    /**
     * @Route("/human", name="player_human_ressourcies")
     */
    public function humanRessources()
    {



        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    /**
     * @Route("/financial", name="player_financial")
     */
    public function financial()
    {



        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    /**
     * @Route("/information", name="player_information")
     */
    public function information()
    {



        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }




}
