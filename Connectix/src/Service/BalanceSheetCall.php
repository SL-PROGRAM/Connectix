<?php


namespace App\Service;


use App\Entity\BalanceSheet;
use App\Entity\Socity;
use App\Repository\BalanceSheetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BalanceSheetCall extends AbstractController
{

    public function frenchGoodsSale(Socity $socity, $turn, BalanceSheetRepository $balanceSheetRepository){
        $frenchGoodsSale = $balanceSheetRepository->findOneBy([
            'socity' => $socity,
            'turn' => $turn,
            'status' => 0,
        ]);
        if ($frenchGoodsSale === null){
            return $frenchGoodsSale = 0;
        }
        else{
            return $frenchGoodsSale->getMarchendiseSales();
        }
    }

    public function frenchProductionSoldGoods(Socity $socity, $turn, BalanceSheetRepository $balanceSheetRepository){
        $frenchGoodsSale = $balanceSheetRepository->findOneBy([
            'socity' => $socity,
            'turn' => $turn,
            'status' => 0,
        ]);
        if ($frenchGoodsSale === null){
            return $frenchGoodsSale = 0;
        }
        else{
            return $frenchGoodsSale->getProductionSales();
        }
    }

    public function stockedProduction(Socity $socity, $turn, BalanceSheetRepository $balanceSheetRepository){
        $stockedProduction = $balanceSheetRepository->findOneBy([
            'socity' => $socity,
            'turn' => $turn,
            'status' => 0 ]);
        if ($stockedProduction === null){
            return $stockedProduction = 0;
        }
        else{
            return $stockedProduction->getProductionStock();
        }
    }

    public function repaymentOnDepreciationAndProvisions(Socity $socity, $turn, BalanceSheetRepository $balanceSheetRepository){
        $repaymentOnDepreciationAndProvisionsLastTurn =
            $balanceSheetRepository->findOneBy(
                [
                    'socity' => $socity,
                    'turn' => $turn-1,
                    'status' => 1, ]);
        if ($repaymentOnDepreciationAndProvisionsLastTurn === null){
            $repaymentOnDepreciationAndProvisionsLastTurn = 0;
        }
        else {
            $repaymentOnDepreciationAndProvisionsLastTurn->getRepaymentOnDepreciationAndProvisions();
        }

        $repaymentOnDepreciationAndProvisions =
            $balanceSheetRepository->findOneBy(
                [
                    'socity' => $socity,
                    'turn' => $turn-1,
                    'status' => 1, ]);
        if ($repaymentOnDepreciationAndProvisions === null){
            $repaymentOnDepreciationAndProvisions = 0;
        }
        else {
            $repaymentOnDepreciationAndProvisions->getRepaymentOnDepreciationAndProvisions();
        }
        return $repaymentOnDepreciationAndProvisions - $repaymentOnDepreciationAndProvisionsLastTurn;
    }

    public function goodsPurchases(Socity $socity, $turn, BalanceSheetRepository $balanceSheetRepository)
    {
        $goodsPurchases = $balanceSheetRepository->findOneBy([
            'socity' => $socity,
            'turn' => $turn,
            'status' => 0]);
        if ($goodsPurchases === null) {
            return $goodsPurchases = 0;
        } else {
            return $goodsPurchases->getMarchendisePurchase();
        }
    }

    public function changeInStock(Socity $socity, $turn, BalanceSheetRepository $balanceSheetRepository){
        $changeInStockLastTurn = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn -1,
                'status' => 0, ]);
        if ($changeInStockLastTurn === null){
            $changeInStockLastTurn = 0;
        }
        else {
            $changeInStockLastTurn->getProductionStock();
        }

        $changeInStock = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn -1,
                'status' => 0, ]);
        if ($changeInStock === null){
            $changeInStock = 0;
        }
        else {
            $changeInStock->getProductionStock();
        }
        return $changeInStock - $changeInStockLastTurn;
    }

    public function purchasesOfRawMaterialsAndSupplies(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $purchasesOfRawMaterialsAndSupplies = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
                'status' => 0, ]);
        if ($purchasesOfRawMaterialsAndSupplies === null){
            return $purchasesOfRawMaterialsAndSupplies = 0;
        }
        else {
            return $purchasesOfRawMaterialsAndSupplies->getRawPurchase();
        }
    }

    public  function otherPurchaseAndExternalCharges(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $otherPurchaseAndExternalCharges = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
                'status' => 0, ]);
        if ($otherPurchaseAndExternalCharges === null){
            return $otherPurchaseAndExternalCharges = 0;
        }
        else {
            return $otherPurchaseAndExternalCharges->getOtherPurchase();
        }
    }

    public function depreciationAndAmortization(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $depreciationAndAmortization = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
                'status' => 0, ]);
        if ($depreciationAndAmortization === null){
            return $depreciationAndAmortization = 0;
        }
        else {
            return $depreciationAndAmortization->getDepreciationAmortization();
        }
    }

    public function intestAndSimilarExpenses(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $intestAndSimilarExpenses = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
                'status' => 0, ]);
        if ($intestAndSimilarExpenses === null){
            return $intestAndSimilarExpenses = 0;
        }
        else {
            return $intestAndSimilarExpenses->getInterestAndSimilarExpenses();
        }
    }

    public function payRoll(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $payRoll = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
                'status' => 0, ]);
        if ($payRoll === null){
            return $payRoll = 0;
        }
        else {
            return $payRoll->getTotalSalary()*12;
        }
    }

    public function interestAndSimilarExpenses(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $interestAndSimilarExpenses = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
                'status' => 0, ]);
        if ($interestAndSimilarExpenses === null){
            return $interestAndSimilarExpenses = 0;
        }
        else {
            return $interestAndSimilarExpenses->getInterestAndSimilarExpenses();
        }
    }

    public function grounds(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $grounds = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
                'status' => 0, ]);
        if ($grounds === null){
            return $grounds = 0;
        }
        else {
            return $grounds->getGrounds();
        }
    }

    public function productionLign(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $productionLign = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
                'status' => 0, ]);
        if ($productionLign === null){
            return 0;
        }
        else {
            return $productionLign->getTechnicalInstallationsEquipment();
        }
    }

    public function factory(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $factory = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
                'status' => 0, ]);
        if ($factory === null){
            return 0;
        }
        else {
            return $factory->getConstructions();
        }
    }

    public function yearResult(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $yearResult = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ]);
        if ($yearResult === null){
            return 0;
        }
        else {
            return $yearResult->getYearProfit();
        }
    }

    public function loanAndDebtsWihCreditInstitutions(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $loanAndDebtsWihCreditInstitutions = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ]);
        if ($loanAndDebtsWihCreditInstitutions === null){
            return 0;
        }
        else {
            return $loanAndDebtsWihCreditInstitutions->getLoanAndDebtsWihCreditInstitutions();
        }
    }

     public function shareCapitalOrIndividual(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
            $shareCapitalOrIndividual = $balanceSheetRepository->findOneBy(
                [
                    'socity' => $socity,
                    'turn' => $turn,
                ]);
            if ($shareCapitalOrIndividual === null){
                return 0;
            }
            else {
                return $shareCapitalOrIndividual->getShareCapitalOrIndividual();
            }
        }

    public function rowMaterial30j(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $rowMaterial = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ]);
        if ($rowMaterial === null){
            return 0;
        }
        else {
            return $rowMaterial->getRowMaterial30j();
        }
    }

    public function rowMaterial60j(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $rowMaterial = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ]);
        if ($rowMaterial === null){
            return 0;
        }
        else {
            return $rowMaterial->getRowMaterial60j();
        }
    }

    public function salesCashing30j(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $rowMaterial = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ]);
        if ($rowMaterial === null){
            return 0;
        }
        else {
            return $rowMaterial->getSalesCashing30j();
        }
    }

    public function salesCashing60j(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $rowMaterial = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ]);
        if ($rowMaterial === null){
            return 0;
        }
        else {
            return $rowMaterial->getSalesCashing60j();
        }
    }

    public function merchandisePurchase30j(Socity $socity, $turn,BalanceSheetRepository $balanceSheetRepository){
        $rowMaterial = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ]);
        if ($rowMaterial === null){
            return 0;
        }
        else {
            return $rowMaterial->getMerchandisePurchase30j();
        }
    }


    public function tva($turn){
        $socity = $this->getUser()->getSocity();
        $balanceSheetRepository = $this->getDoctrine()->getRepository(BalanceSheet::class);

        $balanceSheetToRecord = $balanceSheetRepository->findOneBy([
            'socity' => $socity,
            'turn' => $turn,
            'status' => 0
        ]);

        if ($balanceSheetToRecord === null){
            return 0;
        }
        else {
            return $balanceSheetToRecord->getTva();
        }
    }

    public function availability($turn){
        $socity = $this->getUser()->getSocity();
        $balanceSheetRepository = $this->getDoctrine()->getRepository(BalanceSheet::class);

        $availability = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ]);
        if ($availability === null){
            return 0;
        }
        else {
            return $availability->getAvailability();
        }
    }

    public function taxAndSocialDebts($turn){
        $socity = $this->getUser()->getSocity();
        $balanceSheetRepository = $this->getDoctrine()->getRepository(BalanceSheet::class);

        $taxAndSocialDebts = $balanceSheetRepository->findOneBy(
            [
                'socity' => $socity,
                'turn' => $turn,
            ]);
        if ($taxAndSocialDebts === null){
            return 0;
        }
        else {
            return $taxAndSocialDebts->getTaxAndSocialDebts();
        }
    }




}
