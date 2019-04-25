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

class BalanceSheetRecord extends AbstractController
{

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


        $frenchGoodsSale = $this->merchandiseSales( $socity, $balanceSheetToRecord, $turn, $salesOrderRepository);
        $productionSales = $this->productionSales( $socity, $turn, $salesOrderRepository);
        $merchandisePurchase = $this->merchandisePurchase($socity, $turn, $purchaseOrderRepository);
        $merchandiseStock = $this->merchandiseStock($merchandisePurchase, $frenchGoodsSale, $socity, $turn, $balanceSheetRepository);
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

    private function totalSalary(Socity $socity, $balanceSheetToRecord)
    {
        $payRoll = 0;
        $employees = $socity->getHumanRessourcies();
        foreach ($employees as $employee) {
            $payRoll += $employee->getSalary();
        }
        $balanceSheetToRecord->setTotalSalary($payRoll);
    }

    private function merchandiseSales(Socity $socity, $balanceSheetToRecord, $turn,
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

    private function merchandisePurchase(Socity $socity, $turn,
                                         PurchaseOrderRepository $purchaseOrderRepository){
        $merchandisePurchase = 0;
        $purchases = $purchaseOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($purchases as $purchase){
            $merchandisePurchase += $purchase->getProductQuantityPurchase()*$purchase->getPurchasePrice();
        }
        return $merchandisePurchase;
    }

    private function merchandiseStock($merchandisePurchase, $frenchGoodsSale, Socity $socity, $turn, BalanceSheetRepository $balanceSheetRepository){
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
        return $merchandiseStock = $merchandisePurchase - $frenchGoodsSale + $merchandiseStockLastYear;
    }

    private function productionMake(Socity $socity, $turn, ProductionOrderRepository $productionOrderRepository){
        $productMake = 0;
        $productOrders = $productionOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($productOrders as $productionOrder){
            $productMake += $productionOrder->getRowMaterialCost();
        }
        return $productMake;
    }

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

    private function rawPurchase(Socity $socity, $turn, ProductionOrderRepository $productionOrderRepository){
        $rawPurchase = 0;
        $productOrders = $productionOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($productOrders as $productionOrder){
            $rawPurchase += $productionOrder->getQuantityProductCreat()*$productionOrder->getProduct()->getRowMaterialCost();
        }
        return $rawPurchase;
    }

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

    private function interestAndSimilarExpenses(Socity $socity, LoanRepository $loanRepository){
        $interest = 0;
        $loans = $loanRepository->findBy(['socity' => $socity]);

        foreach ($loans as $loan){
            $interest += $loan->getBorrowAmount()*$loan->getBankInterest()/100;
        }
        return $interest;
    }

    private function grounds(Socity $socity, FactoryRepository $factoryRepository){
        $groundPrice = $socity->getGame()->getGroundCost();
        $totalGroundPrice = 0;
        $grounds = $factoryRepository->findBy(['socity' => $socity]);

        foreach ($grounds as $ground){
            $totalGroundPrice += $groundPrice;
        }
        return $totalGroundPrice;
    }

   private function factory(Socity $socity, FactoryRepository $factoryRepository){
        $factoryPrice = $socity->getGame()->getFactoryCreationCost();
        $totalFactoryPrice = 0;
        $factory = $factoryRepository->findBy(['socity' => $socity]);

        foreach ($factory as $ground){
            $totalFactoryPrice += $factoryPrice;
        }
        return $totalFactoryPrice;
    }

    private function productionLign(Socity $socity, ProductionLignRepository $productionLignRepository){
        $productionLignCost = $socity->getGame()->getProductionLignCreationCost();
        $totalproductionLignCost = 0;
        $productionLign = $productionLignRepository->findBy(['socity' => $socity]);

        foreach ($productionLign as $ground){
            $totalproductionLignCost += $productionLignCost;
        }
        return $totalproductionLignCost;
    }

    private function loanAndDebtsWihCreditInstitutions(Socity $socity, LoanRepository $loanRepository){
        $loanBorrowAmount = 0;
        $loans = $loanRepository->findBy(['socity' => $socity]);

        foreach ($loans as $loan){
            $loanBorrowAmount += $loan->getBorrowAmount();
        }
        return $loanBorrowAmount;
    }

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
