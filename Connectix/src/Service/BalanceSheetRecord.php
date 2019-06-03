<?php


namespace App\Service;


use App\Entity\BalanceSheet;
use App\Entity\Socity;
use App\Repository\AdministrationRepository;
use App\Repository\BalanceSheetRepository;
use App\Repository\FactoryRepository;
use App\Repository\LoanRepository;
use App\Repository\ProductionLignRepository;
use App\Repository\ProductionOrderRepository;
use App\Repository\ProductionRepository;
use App\Repository\PublicityOrderRepository;
use App\Repository\PurchaseOrderRepository;
use App\Repository\ResearcherRepository;
use App\Repository\SalesManParticularRepository;
use App\Repository\SalesManProfessionalRepository;
use App\Repository\SalesManRepository;
use App\Repository\SalesOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BalanceSheetRecord
 * @package App\Service
 */
class BalanceSheetRecord extends AbstractController
{
    /**
     * @param Socity $socity
     * @param $turn
     * @param $status
     * @param AdministrationRepository $administrationRepository
     * @param SalesManRepository $salesManRepository
     * @param ResearcherRepository $researcherRepository
     * @param SalesManProfessionalRepository $salesManProfessionalRepository
     * @param SalesManParticularRepository $salesManParticularRepository
     * @param ProductionRepository $productionRepository
     * @param SalesOrderRepository $salesOrderRepository
     * @param PurchaseOrderRepository $purchaseOrderRepository
     * @param ProductionOrderRepository $productionOrderRepository
     * @param PublicityOrderRepository $publicityOrderRepository
     * @param LoanRepository $loanRepository
     * @param FactoryRepository $factoryRepository
     * @param ProductionLignRepository $productionLignRepository
     * @param BalanceSheetRepository $balanceSheetRepository
     */
    public function record(Socity $socity,
                           $turn,
                           $status,
                           AdministrationRepository $administrationRepository,
                           SalesManRepository $salesManRepository,
                           ResearcherRepository $researcherRepository,
                           SalesManProfessionalRepository $salesManProfessionalRepository,
                           SalesManParticularRepository $salesManParticularRepository,
                           ProductionRepository $productionRepository,
                           SalesOrderRepository $salesOrderRepository,
                           PurchaseOrderRepository $purchaseOrderRepository,
                           ProductionOrderRepository $productionOrderRepository,
                           PublicityOrderRepository $publicityOrderRepository,
                           LoanRepository $loanRepository,
                           FactoryRepository $factoryRepository,
                           ProductionLignRepository $productionLignRepository,
                           BalanceSheetRepository $balanceSheetRepository){


        $balanceSheetToRecord = $balanceSheetRepository->findOneBy([
            'socity' => $socity,
            'turn' => $turn,
            'status' => $status
        ]);

        if ($balanceSheetToRecord === null){
            $balanceSheetToRecord = new BalanceSheet();
            $balanceSheetToRecord->setTurn($turn)
                                ->setSocity($socity)
                                ->setStatus($status)
            ;
        }

        $this->administationActivityCapacity($socity,$balanceSheetToRecord, $administrationRepository);
        $this->salesActivityCapacity($socity, $balanceSheetToRecord, $salesManRepository);
        $this->researchActivityCapacity($socity, $balanceSheetToRecord, $researcherRepository);
        $this->salesActivityProfessionalCapacity($socity, $balanceSheetToRecord, $salesManProfessionalRepository);
        $this->salesActivityParticularCapacity($socity, $balanceSheetToRecord, $salesManParticularRepository);
        $this->setProductionActivityCapacity($socity, $balanceSheetToRecord, $productionRepository);
        $this->totalSalary( $socity, $balanceSheetToRecord);


        $frenchGoodsSale = $this->merchandiseSales( $socity, $turn, $salesOrderRepository);
        $productionSales = $this->productionSales( $socity, $turn, $salesOrderRepository);
        $merchandisePurchase = $this->merchandisePurchase($socity, $turn, $purchaseOrderRepository);
        $merchandiseStock = $this->merchandiseStock($merchandisePurchase, $salesOrderRepository, $socity, $turn, $balanceSheetRepository);
        $productionMake = $this->productionMake($socity, $turn, $productionOrderRepository);
        $productionStock = $this->productionStock($socity, $turn, $balanceSheetRepository, $productionOrderRepository,  $salesOrderRepository);
        $rawPurchase = $this->rawPurchase($socity, $turn, $productionOrderRepository);
        $otherPurchase = $this->otherPurchase( $socity, $turn, $publicityOrderRepository, $frenchGoodsSale, $productionSales);
        $interestAndSimilarExpenses = $this->interestAndSimilarExpenses($socity, $loanRepository);
        $grounds = $this->grounds($socity, $factoryRepository);
        $constructions = $this->factory($socity, $factoryRepository);
        $technicalInstallationsEquipment = $this->productionLign($socity, $productionLignRepository);
        $loanAndDebtsWihCreditInstitutions = $this->loanAndDebtsWihCreditInstitutions($socity, $loanRepository);


        $balanceSheetToRecord->setMarchendisePurchase($merchandisePurchase)
            ->setProductionSales($productionSales)
            ->setMarchendiseSales($frenchGoodsSale)
            ->setMerchandiseStock($merchandiseStock)
            ->setProductionMake($productionMake)
            ->setProductionStock($productionStock)
            ->setRawPurchase($rawPurchase)
            ->setOtherPurchase($otherPurchase)
            ->setInterestAndSimilarExpenses($interestAndSimilarExpenses)
            ->setGrounds($grounds)
            ->setConstructions($constructions)
            ->setTechnicalInstallationsEquipment($technicalInstallationsEquipment)
            ->setLoanAndDebtsWihCreditInstitutions($loanAndDebtsWihCreditInstitutions)
        ;

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetToRecord);
        $entityManager->flush();


    }

    /*
     * use to controle socity capacity
     */
    /**
     * @param Socity $socity
     * @param $balanceSheetToRecord
     * @param AdministrationRepository $administrationRepository
     */
    private function administationActivityCapacity(Socity $socity,
                                                  $balanceSheetToRecord,
                                                  AdministrationRepository $administrationRepository){

        $activityCapacity = 0;
        $administrations = $administrationRepository->findBy([
            'socity' => $socity,
        ]);
        foreach ($administrations as $administration){
            $activityCapacity += $administration->getAdministationActivity();
        }

        $balanceSheetToRecord->setAdministationActivityCapacity($activityCapacity);
    }

    /**
     * @param Socity $socity
     * @param $balanceSheetToRecord
     * @param SalesManRepository $salesManRepository
     */
    private function salesActivityCapacity(Socity $socity,
                                                  $balanceSheetToRecord,
                                                  SalesManRepository $salesManRepository){

        $activityCapacity = 0;
        $salesMen = $salesManRepository->findBy([
            'socity' => $socity,
        ]);
        foreach ($salesMen as $salesMan){
            $activityCapacity += $salesMan->getSalesActivity();
        }

        $balanceSheetToRecord->setSalesActivityCapacity($activityCapacity);
    }

    /**
     * @param Socity $socity
     * @param $balanceSheetToRecord
     * @param ResearcherRepository $Repository
     */
    private function researchActivityCapacity(Socity $socity,
                                                  $balanceSheetToRecord,
                                                  ResearcherRepository $Repository){

        $activityCapacity = 0;
        $people = $Repository->findBy([
            'socity' => $socity,
        ]);
        foreach ($people as $person){
            $activityCapacity += $person->getResearchActivity();
        }

        $balanceSheetToRecord->setResearchActivityCapacity($activityCapacity);
    }

    /**
     * @param Socity $socity
     * @param $balanceSheetToRecord
     * @param SalesManProfessionalRepository $Repository
     */
    private function salesActivityProfessionalCapacity(Socity $socity,
                                                  $balanceSheetToRecord,
                                                  SalesManProfessionalRepository $Repository){

        $activityCapacity = 0;
        $people = $Repository->findBy([
            'socity' => $socity,
        ]);
        foreach ($people as $person){
            $activityCapacity += $person->getSalesActivityProfessional();
        }

        $balanceSheetToRecord->setSalesActivityProfessionalCapacity($activityCapacity);
    }

    /**
     * @param Socity $socity
     * @param $balanceSheetToRecord
     * @param SalesManParticularRepository $Repository
     */
    private function salesActivityParticularCapacity(Socity $socity,
                                                  $balanceSheetToRecord,
                                                  SalesManParticularRepository $Repository){

        $activityCapacity = 0;
        $people = $Repository->findBy([
            'socity' => $socity,
        ]);
        foreach ($people as $person){
            $activityCapacity += $person->getSalesActivityParticular();
        }

        $balanceSheetToRecord->setSalesActivityParticularCapacity($activityCapacity);
    }

    /**
     * @param Socity $socity
     * @param $balanceSheetToRecord
     * @param ProductionRepository $Repository
     */
    private function setProductionActivityCapacity(Socity $socity,
                                                  $balanceSheetToRecord,
                                                  ProductionRepository $Repository){

        $activityCapacity = 0;
        $people = $Repository->findBy([
            'socity' => $socity,
        ]);
        foreach ($people as $person){
            $activityCapacity += $person->getProductionActivity();
        }

        $balanceSheetToRecord->setProductionActivityCapacity($activityCapacity);
    }

    /**
     * @param Socity $socity
     * @param $balanceSheetToRecord
     */
    private function totalSalary(Socity $socity, $balanceSheetToRecord)
    {
        $payRoll = 0;
        $employees = $socity->getHumanRessourcies();
        foreach ($employees as $employee) {
            $payRoll += $employee->getSalary()*12;
        }
        $balanceSheetToRecord->setTotalSalary($payRoll);
    }

    /**
     * @param Socity $socity
     * @param $balanceSheetToRecord
     * @param $turn
     * @param SalesOrderRepository $salesOrderRepository
     * @return float|int
     */
    private function merchandiseSales(Socity $socity, $turn,
                                      SalesOrderRepository $salesOrderRepository){
        $frenchGoodsSale = 0;
        $sales = $salesOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($sales as $sale){
            if($sale->getProduct()->getTechnologicLevel() === 1){
                $frenchGoodsSale += $sale->getProductQuantitySales()*$sale->getSalesPrice();
            }
        }
        return $frenchGoodsSale;
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param SalesOrderRepository $salesOrderRepository
     * @return float|int
     */
    private function productionSales(Socity $socity, $turn,
                                     SalesOrderRepository $salesOrderRepository){
        $productionSales = 0;
        $sales = $salesOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($sales as $sale){
            if($sale->getProduct()->getTechnologicLevel() !== 1){
                $productionSales += $sale->getProductQuantitySales()*$sale->getSalesPrice();
            }
        }
        return $productionSales;
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param PurchaseOrderRepository $purchaseOrderRepository
     * @return float|int
     */
    private function merchandisePurchase(Socity $socity, $turn,
                                         PurchaseOrderRepository $purchaseOrderRepository){
        $merchandisePurchase = 0;
        $purchases = $purchaseOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($purchases as $purchase){
            $merchandisePurchase += $purchase->getProductQuantityPurchase()*$purchase->getPurchasePrice();
        }

        return $merchandisePurchase;
    }

    /**
     * @param $merchandisePurchase
     * @param $frenchGoodsSale
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetRepository $balanceSheetRepository
     * @return int|null
     */
    private function merchandiseStock($merchandisePurchase, SalesOrderRepository $salesOrderRepository, Socity $socity, $turn, BalanceSheetRepository $balanceSheetRepository){
        $merchandiseStockLastYear = $balanceSheetRepository->findOneBy([
            'socity' => $socity,
            'turn' => $turn-1,
            'status' => 1
        ]);
        if ($merchandiseStockLastYear === null) {
            $merchandiseStockLastYear = 0;
        } else {
            $merchandiseStockLastYear = $merchandiseStockLastYear->getMerchandiseStock();
        }
        $stockOut = 0;
        $merchandiseSales = $salesOrderRepository->findBy([
            'socity' => $socity,
            'turn' => $turn,
            'status' => 0
        ]);
        if ($merchandiseSales === null){
            $stockOut = 0;
        }
        else{
            foreach ($merchandiseSales as $merchandiseSale){
                $quantity = $merchandiseSale->getProductQuantitySales();
                $buyPrice = $merchandiseSale->getProduct()->getBuyPrice();

                $stockOut += $quantity*$buyPrice;
            }
        }


        return $merchandiseStock = $merchandisePurchase - $stockOut + $merchandiseStockLastYear;
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param ProductionOrderRepository $productionOrderRepository
     * @return int|null
     */
    private function productionMake(Socity $socity, $turn, ProductionOrderRepository $productionOrderRepository){
        $productMake = 0;
        $productOrders = $productionOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($productOrders as $productionOrder){
            $productMake += $productionOrder->getRowMaterialCost();
        }
        return $productMake;
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param ProductionOrderRepository $productionOrderRepository
     * @param SalesOrderRepository $salesOrderRepository
     * @return float|int|null
     */
    private function productionStock(Socity $socity, $turn, BalanceSheetRepository $balanceSheetRepository, ProductionOrderRepository $productionOrderRepository, SalesOrderRepository $salesOrderRepository){
            $productionStockLastYears = $balanceSheetRepository->findOneBy([
            'socity' => $socity,
            'turn' => $turn-1,
            'status' => 1
        ]);
        if ($productionStockLastYears === null) {
            $productionStockLastYears = 0;
        } else {
            $productionStockLastYears =$productionStockLastYears->getProductionStock();
        }
        $productMake = 0;
        $productOrders = $productionOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        $productionSales = 0;
        $sales = $salesOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);
        $SalesPrice=0;
        $productionStockYears = 0;

        foreach ($sales as $sale){
            if($sale->getProduct()->getTechnologicLevel() !== 1){
                $productionSales += $sale->getProductQuantitySales();
                $SalesPrice = $sale->getSalesPrice();
            }

            foreach ($productOrders as $productionOrder){
                if($productionOrder->getProduct() === $sale->getProduct()){
                    $productMake += $productionOrder->getQuantityProductCreat();
                    $productPrice = $productionOrder->getProduct()->getRowMaterialCost();
                    $productionStock = $productionSales-$productMake;
                    if($productionStock > 0 ){
                        $productionStockYears += $productionStock*$SalesPrice;
                    }
                    else{
                        $productionStockYears += $productionStock*$productPrice;
                    }
                }
            }
        }
        return $productionStock = $productionStockLastYears + $productionStockYears;
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param ProductionOrderRepository $productionOrderRepository
     * @return float|int
     */
    private function rawPurchase(Socity $socity, $turn, ProductionOrderRepository $productionOrderRepository){
        $rawPurchase = 0;
        $productOrders = $productionOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($productOrders as $productionOrder){
            $rawPurchase += $productionOrder->getQuantityProductCreat()*$productionOrder->getProduct()->getRowMaterialCost();
        }
        return $rawPurchase;
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param PublicityOrderRepository $publicityOrderRepository
     * @param $frenchGoodsSale
     * @param $productionSales
     * @return float|int|null
     */
    private function otherPurchase(Socity $socity, $turn, PublicityOrderRepository $publicityOrderRepository, $frenchGoodsSale, $productionSales){
        $publicity = 0;
        $publicityOrders = $publicityOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($publicityOrders as $publicityOrder){
            $publicity += $publicityOrder->getPublicityPrice();
        }

        $extenalExpenses = ($productionSales+$frenchGoodsSale)*$socity->getGame()->getVariableExternalCharges()/100;

        return $otherPurchase = $publicity+$extenalExpenses;
    }

    private function depreciationAmortization(){
    }

    /**
     * @param Socity $socity
     * @param LoanRepository $loanRepository
     * @return float|int
     */
    private function interestAndSimilarExpenses(Socity $socity, LoanRepository $loanRepository){
        $interest = 0;
        $loans = $loanRepository->findBy(['socity' => $socity]);

        foreach ($loans as $loan){
            $interest += $loan->getBorrowAmount()*$loan->getBankInterest()/100;
        }
        return $interest;
    }

    /**
     * @param Socity $socity
     * @param FactoryRepository $factoryRepository
     * @return int|null
     */
    private function grounds(Socity $socity, FactoryRepository $factoryRepository){
        $groundPrice = $socity->getGame()->getGroundCost();
        $totalGroundPrice = 0;
        $grounds = $factoryRepository->findBy(['socity' => $socity]);

        foreach ($grounds as $ground){
            $totalGroundPrice += $groundPrice;
        }
        return $totalGroundPrice;
    }

    /**
     * @param Socity $socity
     * @param FactoryRepository $factoryRepository
     * @return int|null
     */
   private function factory(Socity $socity, FactoryRepository $factoryRepository){
        $factoryPrice = $socity->getGame()->getFactoryCreationCost();
        $totalFactoryPrice = 0;
        $factory = $factoryRepository->findBy(['socity' => $socity]);

        foreach ($factory as $ground){
            $totalFactoryPrice += $factoryPrice;
        }
        return $totalFactoryPrice;
    }

    /**
     * @param Socity $socity
     * @param ProductionLignRepository $productionLignRepository
     * @return int|null
     */
    private function productionLign(Socity $socity, ProductionLignRepository $productionLignRepository){
        $productionLignCost = $socity->getGame()->getProductionLignCreationCost();
        $totalproductionLignCost = 0;
        $productionLign = $productionLignRepository->findBy(['socity' => $socity]);

        foreach ($productionLign as $ground){
            $totalproductionLignCost += $productionLignCost;
        }
        return $totalproductionLignCost;
    }

    /**
     * @param Socity $socity
     * @param LoanRepository $loanRepository
     * @return int|null
     */
    private function loanAndDebtsWihCreditInstitutions(Socity $socity, LoanRepository $loanRepository){
        $loanBorrowAmount = 0;
        $loans = $loanRepository->findBy(['socity' => $socity]);

        foreach ($loans as $loan){
            $loanBorrowAmount += $loan->getBorrowAmount();
        }
        return $loanBorrowAmount;
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param $value
     */
    public function shareCapitalOrIndividual(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository, $value){
        $balanceSheetLastYear = $balanceSheetRepository->findOneBy(['socity' =>$socity, 'turn' => $turn-1]);
        $balanceSheetYear = $balanceSheetRepository->findOneBy(['socity' =>$socity, 'turn' => $turn]);

        if ($balanceSheetLastYear === null){
            $shareCapitalOrIndividual = 0;
        }
        else{
            $shareCapitalOrIndividual = $balanceSheetLastYear->getShareCapitalOrIndividual();
        }

        $shareCapitalOrIndividual += $value;
        $balanceSheetYear->setShareCapitalOrIndividual(($shareCapitalOrIndividual));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetYear);
        $entityManager->flush();

    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param $profitLoss
     * @param BalanceSheetRepository $balanceSheetRepository
     */
    public function recordProfitYears(Socity $socity, $turn, $profitLoss, BalanceSheetRepository $balanceSheetRepository){
        $balanceSheetToRecord = $balanceSheetRepository->findOneBy([
            'socity' => $socity,
            'turn' => $turn,
            'status' => 0
        ]);

        $balanceSheetToRecord->setYearProfit($profitLoss);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetToRecord);
        $entityManager->flush();

    }

    /**
     * @param $value
     */
    public function tva($value){
        $socity = $this->getUser()->getSocity();
        $turn = $this->getUser()->getGame()->getTurn();
        $balanceSheetRepository = $this->getDoctrine()->getRepository(BalanceSheet::class);

        $balanceSheetToRecord = $balanceSheetRepository->findOneBy([
            'socity' => $socity,
            'turn' => $turn,
            'status' => 0
        ]);

        $balanceSheetToRecord->setTva($value);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetToRecord);
        $entityManager->flush();
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param $value
     */
    public function rowMaterial30j(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository, $value){
        $balanceSheetToRecord = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ])
        ->setRowMaterial30j($value);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetToRecord);
        $entityManager->flush();

    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param $value
     */
    public function rowMaterial60j(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository, $value){
        $balanceSheetToRecord = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ])
            ->setRowMaterial60j($value);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetToRecord);
        $entityManager->flush();

    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param $value
     */
    public function merchandisePurchase30j(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository, $value){
        $balanceSheetToRecord = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ])
            ->setMerchandisePurchase30j($value);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetToRecord);
        $entityManager->flush();

    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param $value
     */
    public function salesCashing30j(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository, $value){
        $balanceSheetToRecord = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ])
            ->setSalesCashing30j($value);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetToRecord);
        $entityManager->flush();
    }

    /**
     * @param Socity $socity
     * @param $turn
     * @param BalanceSheetRepository $balanceSheetRepository
     * @param $value
     */
    public function salesCashing60j(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository, $value){
        $balanceSheetToRecord = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ])
            ->setSalesCashing60j($value);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetToRecord);
        $entityManager->flush();
    }

    /**
     * @param $value
     */
    public function availability($value){
        $socity = $this->getUser()->getSocity();
        $turn = $this->getUser()->getGame()->getTurn();
        $balanceSheetRepository = $this->getDoctrine()->getRepository(BalanceSheet::class);

        $balanceSheetToRecord = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ])
            ->setAvailability($value);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetToRecord);
        $entityManager->flush();
    }

    /**
     * @param $value
     */
    public function taxAndSocialDebts($value){
        $socity = $this->getUser()->getSocity();
        $turn = $this->getUser()->getGame()->getTurn();
        $balanceSheetRepository = $this->getDoctrine()->getRepository(BalanceSheet::class);

        $balanceSheetToRecord = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ])
            ->setTaxAndSocialDebts($value);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($balanceSheetToRecord);
        $entityManager->flush();
    }




    //TODO FUNCTION TO CREATE


//;
//$taxes;
//$repaymentOnDepreciationAndProvisions;
//$provisions;
//$provisionOnCurrentAsset;
//$otherExpenses;
//$interestAndSimilarProduct;
//;
//$capitalExceptionalOperatingProduct;
//$capitalExceptionalExpense;
//$researchAndDevelopmentCost;
//$concessionPatentsAndSimilar;



//$customersAndRelatedAccounts;
//$otherReceivables;
//$availability;
//$shareCapitalOrIndividual;
//$premiumIssueMergerContribution;
//$legalReserve;
//$statutoryOrContractualReserves;
//$otherReserves;
//$reportAgain;
//$loanAndDebtsWihCreditInstitutions;
//$tradePayableAndRelatedAccounts;
//
//        $taxAndSocialDebts =0;
//        $otherDebts =0;
//        $socity =0;
//        $professionalSalesPart =0;
//        $particularSalesPart =0;

}
