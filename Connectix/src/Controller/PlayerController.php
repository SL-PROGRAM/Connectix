<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Socity;
use App\Repository\AdministrationRepository;
use App\Repository\BalanceSheetRepository;
use App\Repository\FactoryRepository;
use App\Repository\ProductionLignRepository;
use App\Repository\ProductionOrderRepository;
use App\Repository\ProductionRepository;
use App\Repository\ProductRepository;
use App\Repository\PublicityOrderRepository;
use App\Repository\PurchaseOrderRepository;
use App\Repository\ReseachOrderRepository;
use App\Repository\ResearcherRepository;
use App\Repository\SalesManRepository;
use App\Repository\SalesOrderRepository;
use phpDocumentor\Transformer\Template\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class PlayerController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("/sales", name="player_sales")
     * @param ProductRepository $productRepository
     * @param ReseachOrderRepository $reseachOrderRepository
     * @param SalesOrderRepository $salesOrderRepository
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param PurchaseOrderRepository $purchaseOrderRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sales(
        ProductRepository $productRepository,
        ReseachOrderRepository $reseachOrderRepository,
        SalesOrderRepository $salesOrderRepository,
        BalanceSheetRepository $balanceSheetRepository,
        ProductionOrderRepository $productionOrderRepository,
        PurchaseOrderRepository $purchaseOrderRepository
    ) {
        $socity = $this->getUser()->getSocity();
        $turn = $this->getUser()->getGame()->getTurn();
        $productPurchasePrint = $this->productPurchasePrint($productRepository, $purchaseOrderRepository, $socity);
        $productSalesPrint = $this->productSalesPrint(
            $productRepository,
            $salesOrderRepository,
            $reseachOrderRepository,
            $purchaseOrderRepository,
            $balanceSheetRepository,
            $productionOrderRepository,
            $socity
        );

        return $this->render('player/sales.html.twig', [
            'controller_name' => 'PlayerSales page',
            "productPurchasePrint" => $productPurchasePrint,
            "productSalesPrint" => $productSalesPrint,
            'socity' => $socity,
            'turn' => $turn,
        ]);
    }



    /**
     * @Route("/publicity", name="player_publicity")
     * @param ReseachOrderRepository $reseachOrderRepository
     * @param PublicityOrderRepository $publicityOrderRepository
     * @param ProductRepository $productRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function publicity(
        ReseachOrderRepository $reseachOrderRepository,
        PublicityOrderRepository $publicityOrderRepository,
        ProductRepository $productRepository
    ) {
        $socity = $this->getUser()->getSocity();
        $turn = $this->getUser()->getGame()->getTurn();
        $productPublicityPrint = $this->productPublicityPrint(
            $reseachOrderRepository,
            $publicityOrderRepository,
            $productRepository,
            $socity
        );


        return $this->render('player/publicity.html.twig', [
            'controller_name' => 'PlayerController',
            "productPublicityPrint" => $productPublicityPrint,
            'socity' => $socity,
            'turn' => $turn,
        ]);
    }



    /**
     * @Route("/production", name="player_production")
     * @param FactoryRepository $factoryRepository
     * @param ReseachOrderRepository $reseachOrderRepository
     * @param ProductionOrderRepository $productionOrderRepository
     * @param ProductRepository $productRepository
     * @param ProductionLignRepository $productionLignRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function production(
        FactoryRepository $factoryRepository,
        ReseachOrderRepository $reseachOrderRepository,
        ProductionOrderRepository $productionOrderRepository,
        ProductRepository $productRepository,
        ProductionLignRepository  $productionLignRepository
    ) {
        $socity = $this->getUser()->getSocity();
        $turn = $this->getUser()->getGame()->getTurn();
        $userFactories = $this->userFactories($factoryRepository, $socity);
        $userProductionLigns = $this->userProductionLigns($productionLignRepository, $socity);
        $productionOrderPrint = $this->productionOrderPrint(
            $productionOrderRepository,
            $reseachOrderRepository,
            $productRepository,
            $socity,
            $turn
        );


        $researchOrderPrint = $this->researchOrderPrint($productRepository, $reseachOrderRepository, $socity, $turn);
        $globalProductionPrint = $this->globalProductionPrint($productionOrderPrint, $productionLignRepository, $socity);

        return $this->render('player/production.html.twig', [
            'controller_name' => 'PlayerController',
            "userFactories" => $userFactories,
            'socity' => $socity,
            'turn' => $turn,
            'userProductionLigns' => $userProductionLigns,
            'productionOrderPrint' => $productionOrderPrint,
            'researchOrderPrint' => $researchOrderPrint,
            'globalProductionPrint' => $globalProductionPrint,
        ]);
    }

    /**
     * @Route("/human", name="player_human_ressourcies")
     * @param AdministrationRepository $administrationRepository
     * @param SalesManRepository $salesManRepository
     * @param ResearcherRepository $researcherRepository
     * @param ProductionRepository $productionRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function humanRessources(
        AdministrationRepository $administrationRepository,
        SalesManRepository $salesManRepository,
        ResearcherRepository $researcherRepository,
        ProductionRepository $productionRepository
    ) {
        $socity = $this->getUser()->getSocity();
        $turn = $this->getUser()->getGame()->getTurn();
        $administrationPrint = $this->administrationPrint($administrationRepository, $socity);

        $reseachPrint = $this->reseachPrint($researcherRepository, $socity);

        $salesManPrint = $this->salesManPrint($salesManRepository, $socity);

        $productionPrint = $this->productionPrint($productionRepository, $socity);

        return $this->render('player/human.html.twig', [
            'controller_name' => 'PlayerController',
            'administrationPrint' => $administrationPrint,
            'researchPrint' => $reseachPrint,
            'salesManPrint' => $salesManPrint,
            'productionPrint' => $productionPrint,
            'socity' => $socity,
            'turn' => $turn,
        ]);
    }

    /**
     * @Route("/financial", name="player_financial")
     */
    public function financial()
    {
        $turn = $this->getUser()->getGame()->getTurn();


        return $this->render('player/financial.html.twig', [
            'controller_name' => 'PlayerController',
            'turn' => $turn,
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


    //Function use to return array for sales twig
    private function productPurchasePrint(ProductRepository $productRepository, PurchaseOrderRepository $purchaseOrderRepository, Socity $socity)
    {
        $productPurchaseOrders = $this->productPurchaseOrders($purchaseOrderRepository, $socity);
        $productPurchables = $this->productPurchables($productRepository);


        return $productPurchasePrint = $this->productPurchase($productPurchables, $productPurchaseOrders, $socity);
    }

    private function productSalesPrint(
        ProductRepository $productRepository,
        SalesOrderRepository $salesOrderRepository,
        ReseachOrderRepository $reseachOrderRepository,
        PurchaseOrderRepository $purchaseOrderRepository,
        BalanceSheetRepository $balanceSheetRepository,
        ProductionOrderRepository $productionOrderRepository,
        Socity $socity
    ) {
        $productSalePrint = [];
        $productSalesOrders = $this->productSalesOrders($salesOrderRepository, $socity);
        $productPurchaseOrders = $this->productPurchaseOrders($purchaseOrderRepository, $socity);
        $productSalable = $this->productSalable($reseachOrderRepository, $productRepository, $socity);


        //TODO add differentiation salesType

        foreach ($productSalable as $product) {
            $turn = $socity->getGame()->getTurn();
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
            $productionOrders = $this->productProductionOrders($productionOrderRepository, $socity, $turn);

            foreach ($productPurchaseOrders as $productPurchaseOrder) {
                if($product->getName() === $productPurchaseOrder->getProduct()->getName()){
                    $stock += $productPurchaseOrder->getProductQuantityPurchase();
                }
            }
            foreach ($productionOrders as $productionOrder) {
                if ($productionOrder->getProduct()->getName() === $product->getName()) {
                    $quantity = $productionOrder->getQuantityProductCreat();
                    $stock += $quantity;
                }
            }

            foreach ($productSalesOrders as $productSalesOrder) {
                if ($productSalesOrder->getProduct()->getName() === $product->getName()) {
                    $quantity = $productSalesOrder->getProductQuantitySales();
                    $quantityProfessional = $this->quantityProfessional($quantity, $balanceSheetRepository);
                    $quantityParticular = $this->quantityParticular($quantity, $quantityProfessional);
                    $salesOrderId = $productSalesOrder->getId();
                    $stock -= $quantity;
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

    private function productPublicityPrint(
        ReseachOrderRepository $reseachOrderRepository,
        PublicityOrderRepository $publicityOrderRepository,
        ProductRepository $productRepository,
        Socity $socity
    ) {
        $productPublicityPrint = [];
        $turn = $this->getUser()->getGame()->getTurn();

        $productSalable = $this->productSalable(
            $reseachOrderRepository,
            $productRepository,
            $socity
        );

        foreach ($productSalable as $product) {
            $publicityOrderTurn = $this->productPublicityOrder($product, $publicityOrderRepository, $turn, $socity);
            $publicityOrderLastTurn = $this->productPublicityOrder($product, $publicityOrderRepository, $turn-1, $socity);

            $name = $product->getName();
            $id = $product->getId();
            $cycleLife = $product->getProductLifes(); //TODO modify to select productLifeCycle

            if ($publicityOrderTurn !== null) {
                $productPublicityTurn = $publicityOrderTurn->getPublicityPrice();
                $idPublicityOrderTurn = $publicityOrderTurn->getId();
            } else {
                $productPublicityTurn = 0;
                $idPublicityOrderTurn = null;
            }

            if ($publicityOrderLastTurn !== null) {
                $productPublicityLastTurn = $publicityOrderLastTurn->getPublicityPrice();
            } else {
                $productPublicityLastTurn = 0;
            }
            $variationPublicity = $this->variationPublicity($productPublicityTurn, $productPublicityLastTurn);
            $netSales = 1000; //TODO change with BalanceSheet entity call netSales

            $percentPublicityLastTurn = $this->percentPublicityLastTurn($netSales, $productPublicityLastTurn);

            $publicityPrint = [
                "id" => $id,
                "name" => $name,
                "cycleLife" => $cycleLife,
                "publicityTurn" => $productPublicityTurn,
                "publicityLastTurn" => $productPublicityLastTurn,
                "variationPublicity" => $variationPublicity,
                "percentPublicityLastTurn" => $percentPublicityLastTurn,
                "idPublicityOrderTurn" => $idPublicityOrderTurn
                ];

            array_push($productPublicityPrint, $publicityPrint);
        }

        return $productPublicityPrint;
    }


    private function variationPublicity($productPublicityTurn, $productPublicityLastTurn)
    {
        if ($productPublicityTurn === 0) {
            return "no publicity";
        } else {
            return $variationPublicity = ($productPublicityTurn-$productPublicityLastTurn)/($productPublicityTurn)*100;
        }
    }

    private function percentPublicityLastTurn($netSales, $productPublicityLastTurn)
    {
        if ($netSales === 0) {
            return "no publicity";
        } else {
            return $percentPublicityLastTurn = (($netSales+$productPublicityLastTurn)- $netSales)/$netSales*100;
        }
    }

    private function productPublicityOrder(Product $product, PublicityOrderRepository $publicityOrderRepository, $turn, $socity)
    {
        return $productPublicityOrder = $publicityOrderRepository->findOneBy(["socity" =>$socity, "turn" => $turn, "product" => $product]);
    }

    private function productPurchables(ProductRepository $productRepository)
    {
        return $productLvl1 = $productRepository->findBy(["technologicLevel" => 1]);
    }

    private function productPurchaseOrders(PurchaseOrderRepository $purchaseOrderRepository, Socity $socity)
    {
        $turn = $this->getUser()->getGame()->getTurn();
        return $productPurchaseOrders = $purchaseOrderRepository->findBy(["socity" => $socity, "turn" => $turn]);
    }

    private function productProductionOrders(ProductionOrderRepository $productionOrderRepository, Socity $socity, $turn)
    {
        return $productPurchaseOrders = $productionOrderRepository->findBy(["socity" => $socity, "turn" => $turn]);
    }

    private function quantityProfessional($quantity, BalanceSheetRepository $balanceSheetRepository)
    {
        $turn = $this->getUser()->getGame()->getTurn();
        $balanceSheetTurn = $this->balanceSheetTurn($balanceSheetRepository, $turn);

        if ($balanceSheetTurn == null) {
            $quantityProfessional = $quantity*0.5;
        } else {
            $proCoeficient = $balanceSheetTurn->getParticularSalesPart();
            $quantityProfessional = $quantity*$proCoeficient;
        }

        return $quantityProfessional;
    }

    private function balanceSheetTurn(BalanceSheetRepository $balanceSheetRepository, $turn)
    {
        $socity = $this->getUser()->getSocity();
        $balanceSheetTurn = $balanceSheetRepository->findOneBy(["turn" => $turn, "socity" => $socity]);

        return $balanceSheetTurn;
    }

    private function quantityParticular($quantity, $quantityProfessional)
    {
        return $quantityParticular = $quantity - $quantityProfessional;
    }

    private function purchaseCost(Product $product)
    {
        if ($product->getTechnologicLevel() === 1) {
            return $product->getBuyPrice();
        } else {
            return 100;
            //TODO change value by calculation
        }
    }

    private function productSalesOrders(SalesOrderRepository $salesOrderRepository, Socity $socity)
    {
        $turn = $this->getUser()->getGame()->getTurn();
        return $productPurchaseOrders = $salesOrderRepository->findBy(["socity" => $socity, "turn" => $turn]);
    }

    private function productResearchOrder($Product, ReseachOrderRepository $reseachOrderRepository, Socity $socity)
    {
        return $productReseachOrders = $reseachOrderRepository->findBy(["socity" => $socity, "product" => $Product]);
    }

    private function productPurchase($productPurchables, $productPurchaseOrders,Socity $socity)
    {
        $productPurchasePrint =  [];
        foreach ($productPurchables as $productPurchable) {
            if ($socity->getGame() === $productPurchable->getGame()){
                $quantity = 0;
                $PurchaseOrderId = null;
                $id = $productPurchable->getId();
                $name = $productPurchable->getName();
                $purchasePrice = $productPurchable->getBuyPrice();
                $quantityDiscount = $productPurchable->getQuantityDiscount();
                foreach ($productPurchaseOrders as $productPurchaseOrder) {
                    if ($productPurchaseOrder->getProduct()->getName() === $productPurchable->getName()) {
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
        }
        return $productPurchasePrint;
    }

    private function productSalable(
        ReseachOrderRepository $reseachOrderRepository,
        ProductRepository $productRepository,
        Socity $socity
    ) {
        $productSalable = [];
        $products = $productRepository->findAll();
        foreach ($products as $product) {
            $research = 0;
            $productResearchOrders = $this->productResearchOrder($product, $reseachOrderRepository, $socity);
            foreach ($productResearchOrders as $productResearchOrder) {
                $research += $productResearchOrder->getReseachDo();
            }


            if (($research >= $product->getResearchCost() or $product->getTechnologicLevel() === 1) and $product->getGame() === $socity->getGame()) {
                array_push($productSalable, $product);
            }
        }
        return $productSalable;
    }

    private function userFactories(FactoryRepository $factoryRepository, Socity $socity)
    {
        return $userFactories = $factoryRepository->findBy(["socity" => $socity]);
    }

    private function userProductionLigns(ProductionLignRepository $productionLignRepository, Socity $socity)
    {
        return $userProductionLigns = $productionLignRepository->findBy(["socity" => $socity]);
    }


    private function productionOrderPrint(
        ProductionOrderRepository $productionOrderRepository,
        ReseachOrderRepository $reseachOrderRepository,
        ProductRepository $productRepository,
        Socity $socity,
        $turn
    ) {
        $productProductionOrders = $this->productProductionOrders($productionOrderRepository, $socity, $turn);
        $productSalable = $this->productSalable($reseachOrderRepository, $productRepository, $socity);

        $productionOrderPrint =[];
        foreach ($productSalable as $product) {
            if($product->getTechnologicLevel() !== 1) {
                $quantity = 0;
                $researchOrderId = null;
                $id = $product->getId();
                $name = $product->getName();
                $rowMaterialCost = $product->getRowMaterialCost();
                $productionTimeCost = $product->getProductiorTimeCost();


                foreach ($productProductionOrders as $productProductionOrder) {
                    if ($productProductionOrder->getProduct()->getName() === $product->getName()) {
                        $quantity += $productProductionOrder->getQuantityProductCreat();
                        $researchOrderId = $productProductionOrder->getId();
                    }
                }

                $productionPrint = [
                    "id" => $id,
                    "name" => $name,
                    'rowMaterialCost' => $rowMaterialCost,
                    'productiorTimeCost' => $productionTimeCost,
                    "quantity" => $quantity,
                    'rowMaterialTotalCost' => $rowMaterialCost * $quantity,
                    'productiorTimeTotalCost' => $productionTimeCost * $quantity,
                    'researchOrderId' => $researchOrderId

                ];
                array_push($productionOrderPrint, $productionPrint);
            }
        }
        return $productionOrderPrint;
    }

    private function researchOrderPrint(ProductRepository $productRepository, ReseachOrderRepository $reseachOrderRepository,Socity $socity, $turn)
    {
        //TODO voir comment limiter les recherches en fonctions des lvl et produit déja recherché
        $game = $socity->getGame();
        $products = $productRepository->findBy(["game" => $game]);
        $researchOrderPrint = [];
        foreach ($products as $product) {
            if ($product->getTechnologicLevel() != 1) {
                $productId = $product->getId();
                $name = $product->getName();
                $researchCost = $product->getResearchCost();
                $researchDo = 0;
                $researchOrder = 0;
                $researchOrderId = null;
                $productResearchOrders = $this->productResearchOrder($product, $reseachOrderRepository, $socity);
                foreach ($productResearchOrders as $productResearchOrder) {
                    if ($productResearchOrder->getTurn() === $turn) {
                        $researchOrder += $productResearchOrder->getReseachDo();
                        $researchOrderId = $productResearchOrder->getId();
                    } else {
                        $researchDo += $productResearchOrder->getReseachDo();
                    }
                }
                $researchPrint = [
                    "id" => $productId,
                    "name" => $name,
                    'researchCost' => $researchCost,
                    'researchDo' => $researchDo,
                    "researchOrder" => $researchOrder,
                    'researchOrderId' => $researchOrderId

                ];
                array_push($researchOrderPrint, $researchPrint);
            }
        }
        return $researchOrderPrint;
    }

    private function globalProductionPrint($productionOrderPrint, ProductionLignRepository $productionLignRepository, Socity $socity)
    {
        $totalProductionTimeCapacity = 0;
        $totalTime = 0;
        foreach ($productionOrderPrint as $values) {
            foreach ($values as $key => $value) {
                if ($key == "productiorTimeTotalCost") {
                    $totalTime += $value;
                }
            }
        }
        $userProductionLigns = $this->userProductionLigns($productionLignRepository, $socity);
        foreach ($userProductionLigns as $productionLign) {
            $totalProductionTimeCapacity += $productionLign->getAnnualProductTime();
        }
        if ($totalTime === 0 || $totalProductionTimeCapacity === 0) {
            $totalActivity = "No activity";
        } else {
            $totalActivity = round(($totalProductionTimeCapacity -($totalProductionTimeCapacity - $totalTime))*100/$totalProductionTimeCapacity, 2);
        }

        return $globalProductionPrint = [
            "totalProductionTimeCapacity" => $totalProductionTimeCapacity,
            "totalTimeUse" => $totalTime,
            "totalActivity" => $totalActivity,
        ];
    }

    private function administrationPrint(AdministrationRepository $administrationRepository, Socity $socity)
    {
        $employees = $administrationRepository->findBy(["socity" => $socity]);
        return $employees = $this->employees($employees);
    }

    private function reseachPrint(ResearcherRepository $researcherRepository, Socity $socity)
    {
        $employees = $researcherRepository->findBy(["socity" => $socity]);
        return $employees = $this->employees($employees);
    }

    private function salesManPrint(SalesManRepository $salesManRepository, Socity $socity)
    {
        $employees = $salesManRepository->findBy(["socity" => $socity]);
        return $employees = $this->employees($employees);
    }

    private function productionPrint(ProductionRepository $productionRepository, Socity $socity)
    {
        $employees = $productionRepository->findBy(["socity" => $socity]);
        return $employees = $this->employees($employees);
    }


    private function employees($employees)
    {
        $totalSalarie = 0;
        $totalFormation = 0;
        $totalExperience = 0;
        $totalProductivity = 0;
        $numberEmployeesTotal = 0;

        foreach ($employees as $employee) {
            $totalSalarie += $employee->getSalary();
            $totalFormation +=$employee->getFormation();
            $totalExperience += $employee->getExprience();
            $totalProductivity += $employee->getProductivity();
            $numberEmployeesTotal ++;
        }

        $ProductivityAvg = $this->productivityAvg($totalProductivity, $numberEmployeesTotal);
        $dismissAvg = $this->dismissAvg($totalSalarie, $numberEmployeesTotal, $totalExperience);

        return $employeesPrint = [
            "totalSalarie" => $totalSalarie,
            "numberEmployeesTotal" => $numberEmployeesTotal,
            "ProductivityAvg" => $ProductivityAvg,
            "dismissAvg" => $dismissAvg
        ];
    }

    private function productivityAvg($totalProductivity, $numberEmployeesTotal)
    {
        if ($numberEmployeesTotal === 0) {
            return $productivityAvg = "no employee";
        } else {
            return $productivityAvg = round($totalProductivity/$numberEmployeesTotal, 2);
        }
    }

    private function dismissAvg($totalSalarie, $numberEmployeesTotal, $totalExperience)
    {
        if ($numberEmployeesTotal === 0) {
            return $productivityAvg = "no employee";
        } else {
            return $dismissAvg =
                round($totalSalarie/($numberEmployeesTotal * 12)*(1+$totalExperience), 2);
        }
    }
}
