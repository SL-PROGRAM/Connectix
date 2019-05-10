<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BalanceSheetRepository")
 * Class BalanceSheet
 * @package App\Entity
 */
class BalanceSheet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $turn;

    /**
     * @ORM\Column(type="integer")
     */
    private $status = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $administationActivityCapacity = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesActivityCapacity = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $researchActivityCapacity = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesActivityProfessionalCapacity = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $salesActivityParticularCapacity = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $productionActivityCapacity = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $marchendiseSales = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $productionSales = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $productionStock = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $merchandiseStock = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $totalSalary = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $rawPurchase = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $marchendisePurchase = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $otherPurchase = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $depreciationAmortization = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $taxes = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $repaymentOnDepreciationAndProvisions = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $provisions = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $provisionOnCurrentAsset = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $otherExpenses = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $interestAndSimilarProduct = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $interestAndSimilarExpenses = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $capitalExceptionalOperatingProduct = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $capitalExceptionalExpense = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $researchAndDevelopmentCost = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $concessionPatentsAndSimilar = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $grounds = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $constructions = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $technicalInstallationsEquipment = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $customersAndRelatedAccounts = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $otherReceivables = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $availability = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $shareCapitalOrIndividual = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $premiumIssueMergerContribution = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $legalReserve = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $statutoryOrContractualReserves = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $otherReserves = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $reportAgain = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $loanAndDebtsWihCreditInstitutions = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $tradePayableAndRelatedAccounts = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $taxAndSocialDebts = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $otherDebts = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Socity", inversedBy="balanceSheets")
     */
    private $socity;

    /**
     * @ORM\Column(type="integer")
     */
    private $professionalSalesPart = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $particularSalesPart = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $ProductionMake = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $yearProfit = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $tva = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $rowMaterial30j = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $rowMaterial60j = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $salesCashing30j = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $salesCashing60j = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $customer0j = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $customer30j = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $customer60j = 100;

    /**
     * @ORM\Column(type="float")
     */
    private $merchandisePurchase30j = 0;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAdministationActivityCapacity(): ?int
    {
        return $this->administationActivityCapacity;
    }

    public function setAdministationActivityCapacity(int $administationActivityCapacity): self
    {
        $this->administationActivityCapacity = $administationActivityCapacity;

        return $this;
    }

    public function getSalesActivityCapacity(): ?int
    {
        return $this->salesActivityCapacity;
    }

    public function setSalesActivityCapacity(int $salesActivityCapacity): self
    {
        $this->salesActivityCapacity = $salesActivityCapacity;

        return $this;
    }

    public function getResearchActivityCapacity(): ?int
    {
        return $this->researchActivityCapacity;
    }

    public function setResearchActivityCapacity(int $researchActivityCapacity): self
    {
        $this->researchActivityCapacity = $researchActivityCapacity;

        return $this;
    }

    public function getSalesActivityProfessionalCapacity(): ?int
    {
        return $this->salesActivityProfessionalCapacity;
    }

    public function setSalesActivityProfessionalCapacity(int $salesActivityProfessionalCapacity): self
    {
        $this->salesActivityProfessionalCapacity = $salesActivityProfessionalCapacity;

        return $this;
    }

    public function getSalesActivityParticularCapacity(): ?int
    {
        return $this->salesActivityParticularCapacity;
    }

    public function setSalesActivityParticularCapacity(int $salesActivityParticularCapacity): self
    {
        $this->salesActivityParticularCapacity = $salesActivityParticularCapacity;

        return $this;
    }

    public function getProductionActivityCapacity(): ?int
    {
        return $this->productionActivityCapacity;
    }

    public function setProductionActivityCapacity(int $productionActivityCapacity): self
    {
        $this->productionActivityCapacity = $productionActivityCapacity;

        return $this;
    }

    public function getSocity(): ?Socity
    {
        return $this->socity;
    }

    public function setSocity(?Socity $socity): self
    {
        $this->socity = $socity;

        return $this;
    }

    public function getMarchendiseSales(): ?int
    {
        return $this->marchendiseSales;
    }

    public function setMarchendiseSales(int $marchendiseSales): self
    {
        $this->marchendiseSales = $marchendiseSales;

        return $this;
    }

    public function getProductionSales(): ?int
    {
        return $this->productionSales;
    }

    public function setProductionSales(int $productionSales): self
    {
        $this->productionSales = $productionSales;

        return $this;
    }

    public function getProductionStock(): ?int
    {
        return $this->productionStock;
    }

    public function setProductionStock(int $productionStock): self
    {
        $this->productionStock = $productionStock;

        return $this;
    }

    public function getMerchandiseStock(): ?int
    {
        return $this->merchandiseStock;
    }

    public function setMerchandiseStock(int $merchandiseStock): self
    {
        $this->merchandiseStock = $merchandiseStock;

        return $this;
    }

    public function getTotalSalary(): ?int
    {
        return $this->totalSalary;
    }

    public function setTotalSalary(int $totalSalary): self
    {
        $this->totalSalary = $totalSalary;

        return $this;
    }

    public function getRawPurchase(): ?int
    {
        return $this->rawPurchase;
    }

    public function setRawPurchase(int $rawPurchase): self
    {
        $this->rawPurchase = $rawPurchase;

        return $this;
    }

    public function getMarchendisePurchase(): ?int
    {
        return $this->marchendisePurchase;
    }

    public function setMarchendisePurchase(int $marchendisePurchase): self
    {
        $this->marchendisePurchase = $marchendisePurchase;

        return $this;
    }

    public function getOtherPurchase(): ?int
    {
        return $this->otherPurchase;
    }

    public function setOtherPurchase(int $otherPurchase): self
    {
        $this->otherPurchase = $otherPurchase;

        return $this;
    }

    public function getDepreciationAmortization(): ?int
    {
        return $this->depreciationAmortization;
    }

    public function setDepreciationAmortization(int $depreciationAmortization): self
    {
        $this->depreciationAmortization = $depreciationAmortization;

        return $this;
    }

    public function getTaxes(): ?int
    {
        return $this->taxes;
    }

    public function setTaxes(int $taxes): self
    {
        $this->taxes = $taxes;

        return $this;
    }

    public function getRepaymentOnDepreciationAndProvisions(): ?int
    {
        return $this->repaymentOnDepreciationAndProvisions;
    }

    public function setRepaymentOnDepreciationAndProvisions(int $repaymentOnDepreciationAndProvisions): self
    {
        $this->repaymentOnDepreciationAndProvisions = $repaymentOnDepreciationAndProvisions;

        return $this;
    }

    public function getProvisions(): ?int
    {
        return $this->provisions;
    }

    public function setProvisions(int $provisions): self
    {
        $this->provisions = $provisions;

        return $this;
    }

    public function getProvisionOnCurrentAsset(): ?int
    {
        return $this->provisionOnCurrentAsset;
    }

    public function setProvisionOnCurrentAsset(int $provisionOnCurrentAsset): self
    {
        $this->provisionOnCurrentAsset = $provisionOnCurrentAsset;

        return $this;
    }

    public function getOtherExpenses(): ?int
    {
        return $this->otherExpenses;
    }

    public function setOtherExpenses(int $otherExpenses): self
    {
        $this->otherExpenses = $otherExpenses;

        return $this;
    }

    public function getInterestAndSimilarProduct(): ?int
    {
        return $this->interestAndSimilarProduct;
    }

    public function setInterestAndSimilarProduct(int $interestAndSimilarProduct): self
    {
        $this->interestAndSimilarProduct = $interestAndSimilarProduct;

        return $this;
    }

    public function getInterestAndSimilarExpenses(): ?int
    {
        return $this->interestAndSimilarExpenses;
    }

    public function setInterestAndSimilarExpenses(int $interestAndSimilarExpenses): self
    {
        $this->interestAndSimilarExpenses = $interestAndSimilarExpenses;

        return $this;
    }

    public function getCapitalExceptionalOperatingProduct(): ?int
    {
        return $this->capitalExceptionalOperatingProduct;
    }

    public function setCapitalExceptionalOperatingProduct(int $capitalExceptionalOperatingProduct): self
    {
        $this->capitalExceptionalOperatingProduct = $capitalExceptionalOperatingProduct;

        return $this;
    }

    public function getCapitalExceptionalExpense(): ?int
    {
        return $this->capitalExceptionalExpense;
    }

    public function setCapitalExceptionalExpense(int $capitalExceptionalExpense): self
    {
        $this->capitalExceptionalExpense = $capitalExceptionalExpense;

        return $this;
    }

    public function getResearchAndDevelopmentCost(): ?int
    {
        return $this->researchAndDevelopmentCost;
    }

    public function setResearchAndDevelopmentCost(int $researchAndDevelopmentCost): self
    {
        $this->researchAndDevelopmentCost = $researchAndDevelopmentCost;

        return $this;
    }

    public function getConcessionPatentsAndSimilar(): ?int
    {
        return $this->concessionPatentsAndSimilar;
    }

    public function setConcessionPatentsAndSimilar(int $concessionPatentsAndSimilar): self
    {
        $this->concessionPatentsAndSimilar = $concessionPatentsAndSimilar;

        return $this;
    }

    public function getGrounds(): ?int
    {
        return $this->grounds;
    }

    public function setGrounds(int $grounds): self
    {
        $this->grounds = $grounds;

        return $this;
    }

    public function getConstructions(): ?int
    {
        return $this->constructions;
    }

    public function setConstructions(int $constructions): self
    {
        $this->constructions = $constructions;

        return $this;
    }

    public function getTechnicalInstallationsEquipment(): ?int
    {
        return $this->technicalInstallationsEquipment;
    }

    public function setTechnicalInstallationsEquipment(int $technicalInstallationsEquipment): self
    {
        $this->technicalInstallationsEquipment = $technicalInstallationsEquipment;

        return $this;
    }

    public function getCustomersAndRelatedAccounts(): ?int
    {
        return $this->customersAndRelatedAccounts;
    }

    public function setCustomersAndRelatedAccounts(int $customersAndRelatedAccounts): self
    {
        $this->customersAndRelatedAccounts = $customersAndRelatedAccounts;

        return $this;
    }

    public function getOtherReceivables(): ?int
    {
        return $this->otherReceivables;
    }

    public function setOtherReceivables(int $otherReceivables): self
    {
        $this->otherReceivables = $otherReceivables;

        return $this;
    }

    public function getAvailability(): ?int
    {
        return $this->availability;
    }

    public function setAvailability(int $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getShareCapitalOrIndividual(): ?int
    {
        return $this->shareCapitalOrIndividual;
    }

    public function setShareCapitalOrIndividual(int $shareCapitalOrIndividual): self
    {
        $this->shareCapitalOrIndividual = $shareCapitalOrIndividual;

        return $this;
    }

    public function getPremiumIssueMergerContribution(): ?int
    {
        return $this->premiumIssueMergerContribution;
    }

    public function setPremiumIssueMergerContribution(int $premiumIssueMergerContribution): self
    {
        $this->premiumIssueMergerContribution = $premiumIssueMergerContribution;

        return $this;
    }

    public function getLegalReserve(): ?int
    {
        return $this->legalReserve;
    }

    public function setLegalReserve(int $legalReserve): self
    {
        $this->legalReserve = $legalReserve;

        return $this;
    }

    public function getStatutoryOrContractualReserves(): ?int
    {
        return $this->statutoryOrContractualReserves;
    }

    public function setStatutoryOrContractualReserves(int $statutoryOrContractualReserves): self
    {
        $this->statutoryOrContractualReserves = $statutoryOrContractualReserves;

        return $this;
    }

    public function getOtherReserves(): ?int
    {
        return $this->otherReserves;
    }

    public function setOtherReserves(int $otherReserves): self
    {
        $this->otherReserves = $otherReserves;

        return $this;
    }

    public function getReportAgain(): ?int
    {
        return $this->reportAgain;
    }

    public function setReportAgain(int $reportAgain): self
    {
        $this->reportAgain = $reportAgain;

        return $this;
    }

    public function getLoanAndDebtsWihCreditInstitutions(): ?int
    {
        return $this->loanAndDebtsWihCreditInstitutions;
    }

    public function setLoanAndDebtsWihCreditInstitutions(int $loanAndDebtsWihCreditInstitutions): self
    {
        $this->loanAndDebtsWihCreditInstitutions = $loanAndDebtsWihCreditInstitutions;

        return $this;
    }

    public function getTradePayableAndRelatedAccounts(): ?int
    {
        return $this->tradePayableAndRelatedAccounts;
    }

    public function setTradePayableAndRelatedAccounts(int $tradePayableAndRelatedAccounts): self
    {
        $this->tradePayableAndRelatedAccounts = $tradePayableAndRelatedAccounts;

        return $this;
    }

    public function getTaxAndSocialDebts(): ?int
    {
        return $this->taxAndSocialDebts;
    }

    public function setTaxAndSocialDebts(int $taxAndSocialDebts): self
    {
        $this->taxAndSocialDebts = $taxAndSocialDebts;

        return $this;
    }

    public function getOtherDebts(): ?int
    {
        return $this->otherDebts;
    }

    public function setOtherDebts(int $otherDebts): self
    {
        $this->otherDebts = $otherDebts;

        return $this;
    }

    public function getProfessionalSalesPart(): ?int
    {
        return $this->professionalSalesPart;
    }

    public function setProfessionalSalesPart(int $professionalSalesPart): self
    {
        $this->professionalSalesPart = $professionalSalesPart;

        return $this;
    }

    public function getParticularSalesPart(): ?int
    {
        return $this->particularSalesPart;
    }

    public function setParticularSalesPart(int $particularSalesPart): self
    {
        $this->particularSalesPart = $particularSalesPart;

        return $this;
    }

    public function __toString()
    {
        return 'BalanceSheet';
    }

    public function getProductionMake(): ?int
    {
        return $this->ProductionMake;
    }

    public function setProductionMake(int $ProductionMake): self
    {
        $this->ProductionMake = $ProductionMake;

        return $this;
    }

    public function getYearProfit(): ?float
    {
        return $this->yearProfit;
    }

    public function setYearProfit(float $yearProfit): self
    {
        $this->yearProfit = $yearProfit;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getRowMaterial30j(): ?float
    {
        return $this->rowMaterial30j;
    }

    public function setRowMaterial30j(float $rowMaterial30j): self
    {
        $this->rowMaterial30j = $rowMaterial30j;

        return $this;
    }

    public function getRowMaterial60j(): ?float
    {
        return $this->rowMaterial60j;
    }

    public function setRowMaterial60j(float $rowMaterial60j): self
    {
        $this->rowMaterial60j = $rowMaterial60j;

        return $this;
    }

    public function getSalesCashing30j(): ?float
    {
        return $this->salesCashing30j;
    }

    public function setSalesCashing30j(float $salesCashing30j): self
    {
        $this->salesCashing30j = $salesCashing30j;

        return $this;
    }

    public function getSalesCashing60j(): ?float
    {
        return $this->salesCashing60j;
    }

    public function setSalesCashing60j(float $salesCashing60j): self
    {
        $this->salesCashing60j = $salesCashing60j;

        return $this;
    }

    public function getCustomer0j(): ?int
    {
        return $this->customer0j;
    }

    public function setCustomer0j(int $customer0j): self
    {
        $this->customer0j = $customer0j;

        return $this;
    }

    public function getCustomer30j(): ?int
    {
        return $this->customer30j;
    }

    public function setCustomer30j(int $customer30j): self
    {
        $this->customer30j = $customer30j;

        return $this;
    }

    public function getCustomer60j(): ?int
    {
        return $this->customer60j;
    }

    public function setCustomer60j(int $customer60j): self
    {
        $this->customer60j = $customer60j;

        return $this;
    }

    public function getMerchandisePurchase30j(): ?float
    {
        return $this->merchandisePurchase30j;
    }

    public function setMerchandisePurchase30j(float $merchandisePurchase30j): self
    {
        $this->merchandisePurchase30j = $merchandisePurchase30j;

        return $this;
    }
}
