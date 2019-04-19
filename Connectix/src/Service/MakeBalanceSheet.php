<?php


namespace App\Service;


use App\Entity\BalanceSheet;
use App\Entity\Game;
use App\Entity\Socity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MakeBalanceSheet extends AbstractController
{
    public function makeBalanceSheet(Socity $socity, Game $game){
        $turn = $game->getTurn();
        $balanceSheet = new BalanceSheet();
        $balanceSheet->setSocity($socity)
            ->setStatus(0)
            ->setTurn($turn)
            ->setAdministationActivityCapacity(0)
            ->setAvailability(0)
            ->setCapitalExceptionalExpense(0)
            ->setSalesActivityCapacity(0)
            ->setResearchActivityCapacity(0)
            ->setSalesActivityProfessionalCapacity(0)
            ->setSalesActivityParticularCapacity(0)
            ->setProductionActivityCapacity(0)
            ->setMarchendiseSales(0)
            ->setProductionSales(0)
            ->setProductionStock(0)
            ->setMerchandiseStock(0)
            ->setTotalSalary(0)
            ->setRawPurchase(0)
            ->setMarchendisePurchase(0)
            ->setOtherPurchase(0)
            ->setDepreciationAmortization(0)
            ->setTaxes(0)
            ->setRepaymentOnDepreciationAndProvisions(0)
            ->setProvisions(0)
            ->setProvisionOnCurrentAsset(0)
            ->setOtherExpenses(0)
            ->setInterestAndSimilarProduct(0)
            ->setInterestAndSimilarExpenses(0)
            ->setCapitalExceptionalOperatingProduct(0)
            ->setCapitalExceptionalExpense(0)
            ->setResearchAndDevelopmentCost(0)
            ->setConcessionPatentsAndSimilar(0)
            ->setGrounds(0)
            ->setConstructions(0)
            ->setTechnicalInstallationsEquipment(0)
            ->setCustomersAndRelatedAccounts(0)
            ->setOtherReceivables(0)
            ->setAvailability(0)
            ->setShareCapitalOrIndividual($game->getSocityStartShareCapital())
            ->setPremiumIssueMergerContribution(0)
            ->setLegalReserve(0)
            ->setStatutoryOrContractualReserves(0)
            ->setOtherReserves(0)
            ->setReportAgain(0)
            ->setLoanAndDebtsWihCreditInstitutions(0)
            ->setTradePayableAndRelatedAccounts(0)
            ->setTaxAndSocialDebts(0)
            ->setOtherDebts(0)
            ->setProfessionalSalesPart(0)
            ->setParticularSalesPart(0);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager  ->persist($balanceSheet);
        $entityManager  ->flush();

    }
}
