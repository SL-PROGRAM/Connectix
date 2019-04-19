<?php


namespace App\Service;


use App\Entity\BalanceSheet;
use App\Entity\Socity;
use App\Repository\AdministrationRepository;
use App\Repository\BalanceSheetRepository;
use App\Repository\ProductionRepository;
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
        $this->merchandiseSales( $socity, $balanceSheetToRecord, $turn, $salesOrderRepository);
        $this->productionSales( $socity, $balanceSheetToRecord, $turn, $salesOrderRepository);
        $this->merchandisePurchase($socity, $balanceSheetToRecord, $turn, $purchaseOrderRepository);


    }

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
        $balanceSheetToRecord->setMarchendiseSales($frenchGoodsSale);
    }

    private function productionSales(Socity $socity, $balanceSheetToRecord, $turn,
                                     SalesOrderRepository $salesOrderRepository){
        $frenchGoodsSale = 0;
        $sales = $salesOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($sales as $sale){
            if($sale->getProduct()->getTechnologicLevel() !== 1){
                $frenchGoodsSale += $sale->getProductQuantitySales()*$sale->getSalesPrice();
            }
        }
        $balanceSheetToRecord->setProductionSales($frenchGoodsSale);
    }

    private function merchandisePurchase(Socity $socity, $balanceSheetToRecord, $turn, PurchaseOrderRepository $purchaseOrderRepository){
        $merchandisePurchase = 0;
        $purchases = $purchaseOrderRepository->findBy(['socity' => $socity, 'turn' => $turn]);

        foreach ($purchases as $purchase){
            $merchandisePurchase += $purchase->getProductQuantityPurchase()*$purchase->getPurchasePrice();
        }
        $balanceSheetToRecord->setMarchendisePurchase($merchandisePurchase);
    }







    //TODO FUNCTION TO CREATE


//$productionStock;
//$merchandiseStock;
//$totalSalary;
//$rawPurchase;
//$otherPurchase;
//$depreciationAmortization;
//$taxes;
//$repaymentOnDepreciationAndProvisions;
//$provisions;
//$provisionOnCurrentAsset;
//$otherExpenses;
//$interestAndSimilarProduct;
//$interestAndSimilarExpenses;
//$capitalExceptionalOperatingProduct;
//$capitalExceptionalExpense;
//$researchAndDevelopmentCost;
//$concessionPatentsAndSimilar;
// $grounds;
//$constructions;
//$technicalInstallationsEquipment;
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
