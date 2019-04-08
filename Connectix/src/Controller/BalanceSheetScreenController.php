<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Yaml\Yaml;

/**
 * Require ROLE_USER for *every* controller method in this class.
 *
 * @IsGranted("ROLE_USER")
 */
class BalanceSheetScreenController extends AbstractController
{
    /**
     * @Route("/balancesheetscreen", name="balance_sheet")
     */
    public function index()
    {
        $actualYearActiveBalanceSheetBrut = $this->actualYearActiveBalanceSheetBrut();
        $actualYearActiveBalanceSheetDepreciationProvision = $this->actualYearActiveBalanceSheetDepreciationProvision();
        $actualYearActiveBalanceSheetNet = $this->actualYearActiveBalanceSheetNet(
            $actualYearActiveBalanceSheetBrut,
            $actualYearActiveBalanceSheetDepreciationProvision
        );
        $lastYearActiveBalanceSheet = $this->lastYearActiveBalanceSheet();
        $actualYearPassiveBalanceSheet = $this->actualYearPassiveBalanceSheet();
        $lastYearPassiveBalanceSheet = $this->lastYearPassiveBalanceSheet();


        return $this->render('balance_sheet_screen/index.html.twig', [
            'actualYearActiveBalanceSheetBrut' => $actualYearActiveBalanceSheetBrut,
            'actualYearActiveBalanceSheetDepreciationProvision' => $actualYearActiveBalanceSheetDepreciationProvision,
            'actualYearActiveBalanceSheetNet' => $actualYearActiveBalanceSheetNet,
            'lastYearActiveBalanceSheet' => $lastYearActiveBalanceSheet,
            'actualYearPassiveBalanceSheet' => $actualYearPassiveBalanceSheet,
            'lastYearPassiveBalanceSheet' => $lastYearPassiveBalanceSheet,
            'controller_name' => 'BalanceSheetController',
        ]);
    }



    private function actualYearActiveBalanceSheetBrut()
    {
        //TODO RETURN TABLE TO INDEX
        //TODO GET PARAMETER AND GIVE THEM TO calculationActiveBalanceSheet
        $administrationFees = 1000;
        $researchAndDevelopmentCost = 1000;
        $concessionPatentsAndSimilar = 1000;
        $commercialFund = 0;
        $otherIntangibleAsset = 0;
        $advancesAndDownPaymentOnIntangibleAssets = 0;
        $grounds = 0;
        $constructions = 0;
        $technicalInstallationsEquipment = 0;
        $otherTangibleFixedAssets = 0;
        $assetInProgress = 0;
        $advancesAndDownPaymentOnTangibleAssets = 0;
        $investmentsAccountedForEquityMethod = 0;
        $otherParticipations = 0;
        $receivablesRelatedEquityInvestments = 0;
        $otherLockedSecurities = 0;
        $loans = 0;
        $otherFinancialAssets = 0;
        $rowMaterialsSupplies = 0;
        $outstandingProducingGoods = 0;
        $outstandingServices = 0;
        $intermediateAndFinishProduct = 0;
        $merchandise = 0;
        $advancesAndPrepaymentOrders = 0;
        $customersAndRelatedAccounts = 0;
        $otherReceivables = 0;
        $subscribedAndCallCapitalUnpaid = 0;
        $marketableSecurities = 0;
        $bank = 0;
        $availability = 0;
        $prepaidExpenses = 0;
        $subscribedCapitalNotCall = 0;
        $expensesSpreadOverSeveralFinancialYears = 0;
        $bondRepaymentPremiums = 0;
        $activeConversionDifferences = 0;


        return $lastYearActiveBalanceSheet = $this->calculationActiveBalanceSheet(
            $administrationFees,
            $researchAndDevelopmentCost,
            $concessionPatentsAndSimilar,
            $commercialFund,
            $otherIntangibleAsset,
            $advancesAndDownPaymentOnIntangibleAssets,
            $grounds,
            $constructions,
            $technicalInstallationsEquipment,
            $otherTangibleFixedAssets,
            $assetInProgress,
            $advancesAndDownPaymentOnTangibleAssets,
            $investmentsAccountedForEquityMethod,
            $otherParticipations,
            $receivablesRelatedEquityInvestments,
            $otherLockedSecurities,
            $loans,
            $otherFinancialAssets,
            $rowMaterialsSupplies,
            $outstandingProducingGoods,
            $outstandingServices,
            $intermediateAndFinishProduct,
            $merchandise,
            $advancesAndPrepaymentOrders,
            $customersAndRelatedAccounts,
            $otherReceivables,
            $subscribedAndCallCapitalUnpaid,
            $marketableSecurities,
            $bank,
            $availability,
            $prepaidExpenses,
            $subscribedCapitalNotCall,
            $expensesSpreadOverSeveralFinancialYears,
            $bondRepaymentPremiums,
            $activeConversionDifferences
        );
    }

    private function actualYearActiveBalanceSheetDepreciationProvision()
    {
        //TODO RETURN TABLE TO INDEX
        //TODO GET PARAMETER AND GIVE THEM TO calculationActiveBalanceSheet
        $administrationFees = 100;
        $researchAndDevelopmentCost = 100;
        $concessionPatentsAndSimilar = 100;
        $commercialFund = 0;
        $otherIntangibleAsset = 0;
        $advancesAndDownPaymentOnIntangibleAssets = 0;
        $grounds = 0;
        $constructions = 0;
        $technicalInstallationsEquipment = 0;
        $otherTangibleFixedAssets = 0;
        $assetInProgress = 0;
        $advancesAndDownPaymentOnTangibleAssets = 0;
        $investmentsAccountedForEquityMethod = 0;
        $otherParticipations = 0;
        $receivablesRelatedEquityInvestments = 0;
        $otherLockedSecurities = 0;
        $loans = 0;
        $otherFinancialAssets = 0;
        $rowMaterialsSupplies = 0;
        $outstandingProducingGoods = 0;
        $outstandingServices = 0;
        $intermediateAndFinishProduct = 0;
        $merchandise = 0;
        $advancesAndPrepaymentOrders = 0;
        $customersAndRelatedAccounts = 0;
        $otherReceivables = 0;
        $subscribedAndCallCapitalUnpaid = 0;
        $marketableSecurities = 0;
        $bank = 0;
        $availability = 0;
        $prepaidExpenses = 0;
        $subscribedCapitalNotCall = 0;
        $expensesSpreadOverSeveralFinancialYears = 0;
        $bondRepaymentPremiums = 0;
        $activeConversionDifferences = 0;


        return $lastYearActiveBalanceSheet = $this->calculationActiveBalanceSheet(
            $administrationFees,
            $researchAndDevelopmentCost,
            $concessionPatentsAndSimilar,
            $commercialFund,
            $otherIntangibleAsset,
            $advancesAndDownPaymentOnIntangibleAssets,
            $grounds,
            $constructions,
            $technicalInstallationsEquipment,
            $otherTangibleFixedAssets,
            $assetInProgress,
            $advancesAndDownPaymentOnTangibleAssets,
            $investmentsAccountedForEquityMethod,
            $otherParticipations,
            $receivablesRelatedEquityInvestments,
            $otherLockedSecurities,
            $loans,
            $otherFinancialAssets,
            $rowMaterialsSupplies,
            $outstandingProducingGoods,
            $outstandingServices,
            $intermediateAndFinishProduct,
            $merchandise,
            $advancesAndPrepaymentOrders,
            $customersAndRelatedAccounts,
            $otherReceivables,
            $subscribedAndCallCapitalUnpaid,
            $marketableSecurities,
            $bank,
            $availability,
            $prepaidExpenses,
            $subscribedCapitalNotCall,
            $expensesSpreadOverSeveralFinancialYears,
            $bondRepaymentPremiums,
            $activeConversionDifferences
        );
    }

    private function actualYearActiveBalanceSheetNet(
        array $actualYearActiveBalanceSheetBrut,
        array $actualYearActiveBalanceSheetDepreciationProvision
    ) {
        $actualYearActiveBalanceSheetNet = [];
        foreach ($actualYearActiveBalanceSheetBrut as $keyBrut => $elemBrut) {
            foreach ($actualYearActiveBalanceSheetDepreciationProvision as $keyDepreciationProvision => $elemDepreciationProvision) {
                if ($keyBrut === $keyDepreciationProvision) {
                    $actualYearActiveBalanceSheetNet[$keyBrut] = ($elemBrut - $elemDepreciationProvision);
                }
            }
        }
        return $actualYearActiveBalanceSheetNet;
    }

    private function lastYearActiveBalanceSheet()
    {
        //TODO RETURN TABLE TO INDEX
        //TODO GET PARAMETER AND GIVE THEM TO calculationActiveBalanceSheet
        $administrationFees = 0;
        $researchAndDevelopmentCost = 0;
        $concessionPatentsAndSimilar = 0;
        $commercialFund = 0;
        $otherIntangibleAsset = 0;
        $assetInProgress = 0;
        $advancesAndDownPaymentOnIntangibleAssets = 0;
        $grounds = 0;
        $constructions = 0;
        $technicalInstallationsEquipment = 0;
        $otherTangibleFixedAssets = 0;
        $advancesAndDownPaymentOnTangibleAssets = 0;
        $investmentsAccountedForEquityMethod = 0;
        $otherParticipations = 0;
        $receivablesRelatedEquityInvestments = 0;
        $otherLockedSecurities = 0;
        $loans = 0;
        $otherFinancialAssets = 0;
        $rowMaterialsSupplies = 0;
        $outstandingProducingGoods = 0;
        $outstandingServices = 0;
        $intermediateAndFinishProduct = 0;
        $merchandise = 0;
        $advancesAndPrepaymentOrders = 0;
        $customersAndRelatedAccounts = 0;
        $otherReceivables = 0;
        $subscribedAndCallCapitalUnpaid = 0;
        $marketableSecurities = 0;
        $bank = 0;
        $availability = 0;
        $prepaidExpenses = 0;
        $subscribedCapitalNotCall = 0;
        $expensesSpreadOverSeveralFinancialYears = 0;
        $bondRepaymentPremiums = 0;
        $activeConversionDifferences = 0;


        return $lastYearActiveBalanceSheet = $this->calculationActiveBalanceSheet(
            $administrationFees,
            $researchAndDevelopmentCost,
            $concessionPatentsAndSimilar,
            $commercialFund,
            $otherIntangibleAsset,
            $advancesAndDownPaymentOnIntangibleAssets,
            $grounds,
            $constructions,
            $technicalInstallationsEquipment,
            $otherTangibleFixedAssets,
            $assetInProgress,
            $advancesAndDownPaymentOnTangibleAssets,
            $investmentsAccountedForEquityMethod,
            $otherParticipations,
            $receivablesRelatedEquityInvestments,
            $otherLockedSecurities,
            $loans,
            $otherFinancialAssets,
            $rowMaterialsSupplies,
            $outstandingProducingGoods,
            $outstandingServices,
            $intermediateAndFinishProduct,
            $merchandise,
            $advancesAndPrepaymentOrders,
            $customersAndRelatedAccounts,
            $otherReceivables,
            $subscribedAndCallCapitalUnpaid,
            $marketableSecurities,
            $bank,
            $availability,
            $prepaidExpenses,
            $subscribedCapitalNotCall,
            $expensesSpreadOverSeveralFinancialYears,
            $bondRepaymentPremiums,
            $activeConversionDifferences
        );
    }

    private function calculationActiveBalanceSheet(
        $administrationFees,
        $researchAndDevelopmentCost,
        $concessionPatentsAndSimilar,
        $commercialFund,
        $otherIntangibleAsset,
        $advancesAndDownPaymentOnIntangibleAssets,
        $grounds,
        $constructions,
        $technicalInstallationsEquipment,
        $otherTangibleFixedAssets,
        $assetInProgress,
        $advancesAndDownPaymentOnTangibleAssets,
        $investmentsAccountedForEquityMethod,
        $otherParticipations,
        $receivablesRelatedEquityInvestments,
        $otherLockedSecurities,
        $loans,
        $otherFinancialAssets,
        $rowMaterialsSupplies,
        $outstandingProducingGoods,
        $outstandingServices,
        $intermediateAndFinishProduct,
        $merchandise,
        $advancesAndPrepaymentOrders,
        $customersAndRelatedAccounts,
        $otherReceivables,
        $subscribedAndCallCapitalUnpaid,
        $marketableSecurities,
        $bank,
        $availability,
        $prepaidExpenses,
        $subscribedCapitalNotCall,
        $expensesSpreadOverSeveralFinancialYears,
        $bondRepaymentPremiums,
        $activeConversionDifferences
    ) {
        //TODO RETURN CALCULATION TABLE TO actualYearActiveBalanceSheet
        //TODO RETURN CALCULATION TABLE TO lastYearActiveBalanceSheet
        $totalFixedAsset = $this->totalFixedAsset(
            $administrationFees,
            $researchAndDevelopmentCost,
            $concessionPatentsAndSimilar,
            $commercialFund,
            $otherIntangibleAsset,
            $advancesAndDownPaymentOnIntangibleAssets,
            $grounds,
            $constructions,
            $technicalInstallationsEquipment,
            $otherTangibleFixedAssets,
            $advancesAndDownPaymentOnTangibleAssets,
            $investmentsAccountedForEquityMethod,
            $otherParticipations,
            $receivablesRelatedEquityInvestments,
            $otherLockedSecurities,
            $loans,
            $otherFinancialAssets
        );

        $totalActiveCirculating = $this->totalActiveCirculating(
            $rowMaterialsSupplies,
            $outstandingProducingGoods,
            $outstandingServices,
            $intermediateAndFinishProduct,
            $merchandise,
            $advancesAndPrepaymentOrders,
            $customersAndRelatedAccounts,
            $otherReceivables,
            $subscribedAndCallCapitalUnpaid,
            $marketableSecurities,
            $bank,
            $availability,
            $prepaidExpenses
        );

        $totalGeneralActiveBalanceSheet = $this->totalGeneralActiveBalanceSheet(
            $subscribedCapitalNotCall,
            $totalFixedAsset,
            $totalActiveCirculating,
            $expensesSpreadOverSeveralFinancialYears,
            $bondRepaymentPremiums,
            $activeConversionDifferences
        );

        return $calculationActiveBalanceSheet = [
            "administrationFees" => $administrationFees,
            "researchAndDevelopmentCost" => $researchAndDevelopmentCost,
            "concessionPatentsAndSimilar" => $concessionPatentsAndSimilar,
            "commercialFund" =>$commercialFund,
            "otherIntangibleAsset" => $otherIntangibleAsset,
            "advancesAndDownPaymentOnIntangibleAssets" => $advancesAndDownPaymentOnIntangibleAssets,
            "grounds" => $grounds,
            "constructions" => $constructions,
            "technicalInstallationsEquipment" => $technicalInstallationsEquipment,
            "otherTangibleFixedAssets" => $otherTangibleFixedAssets,
            "assetInProgress" => $assetInProgress,
            "advancesAndDownPaymentOnTangibleAssets" => $advancesAndDownPaymentOnTangibleAssets,
            "investmentsAccountedForEquityMethod" => $investmentsAccountedForEquityMethod,
            "otherParticipations" => $otherParticipations,
            "receivablesRelatedEquityInvestments" => $receivablesRelatedEquityInvestments,
            "otherLockedSecurities" => $otherLockedSecurities,
            "loans" => $loans,
            "otherFinancialAssets" => $otherFinancialAssets,
            "rowMaterialsSupplies" => $rowMaterialsSupplies,
            "outstandingProducingGoods" => $outstandingProducingGoods,
            "outstandingServices" => $outstandingServices,
            "intermediateAndFinishProduct" => $intermediateAndFinishProduct,
            "merchandise" => $merchandise,
            "advancesAndPrepaymentOrders" => $advancesAndPrepaymentOrders,
            "customersAndRelatedAccounts" => $customersAndRelatedAccounts,
            "otherReceivables" => $otherReceivables,
            "subscribedAndCallCapitalUnpaid" => $subscribedAndCallCapitalUnpaid,
            "marketableSecurities" => $marketableSecurities,
            "bank" => $bank,
            "availability" => $availability,
            "prepaidExpenses" => $prepaidExpenses,
            "subscribedCapitalNotCall" => $subscribedCapitalNotCall,
            "expensesSpreadOverSeveralFinancialYears" => $expensesSpreadOverSeveralFinancialYears,
            "bondRepaymentPremiums" => $bondRepaymentPremiums,
            "activeConversionDifferences" => $activeConversionDifferences,
            "totalFixedAsset" =>$totalFixedAsset,
            "totalActiveCirculating" => $totalActiveCirculating,
            "totalGeneralActiveBalanceSheet" => $totalGeneralActiveBalanceSheet
        ];
    }

    private function actualYearPassiveBalanceSheet()
    {

        //TODO RETURN TABLE TO INDEX
        //TODO GET PARAMETER AND GIVE THEM TO calculationPassiveBalanceSheet
        $shareCapitalOrIndividual = 0;
        $convertibleBonds = 0;
        $otherBonds = 0;
        $loanAndDebtsWihCreditInstitutions = 0;
        $borrowingAndOtherFinancialDebts = 0;
        $AdvancesAndDownPaymentReceived = 0;
        $tradePayableAndRelatedAccounts = 0;
        $taxAndSocialDebts = 0;
        $debtsOnFixedAssetsAndRelatedAccount = 0;
        $otherDebts = 0;
        $prepaidIncome = 0;
        $premiumIssueMergerContribution = 0;
        $revaluationDifferences = 0;
        $legalReserve = 0;
        $statutoryOrContractualReserves = 0;
        $regulatedReserves = 0;
        $otherReserves = 0;
        $reportAgain = 0;
        $yearProfit = 0;
        $investmentGrant = 0;
        $regulatedProvisions = 0;
        $proceedsFromEquitySecuritiesIssues = 0;
        $conditionedAdvances = 0;
        $riskProvision = 0;
        $expensesProvision = 0;
        $liabilitiesTranslationDifferences = 0;

        return $actualYearPassiveBalanceSheet = $this->calculationPassiveBalanceSheet(
            $shareCapitalOrIndividual,
            $premiumIssueMergerContribution,
            $revaluationDifferences,
            $legalReserve,
            $statutoryOrContractualReserves,
            $regulatedReserves,
            $otherReserves,
            $reportAgain,
            $yearProfit,
            $investmentGrant,
            $regulatedProvisions,
            $proceedsFromEquitySecuritiesIssues,
            $conditionedAdvances,
            $riskProvision,
            $expensesProvision,
            $convertibleBonds,
            $otherBonds,
            $loanAndDebtsWihCreditInstitutions,
            $borrowingAndOtherFinancialDebts,
            $AdvancesAndDownPaymentReceived,
            $tradePayableAndRelatedAccounts,
            $taxAndSocialDebts,
            $debtsOnFixedAssetsAndRelatedAccount,
            $otherDebts,
            $prepaidIncome,
            $liabilitiesTranslationDifferences
        );
    }


    private function lastYearPassiveBalanceSheet()
    {
        //TODO RETURN TABLE TO INDEX
        //TODO GET PARAMETER AND GIVE THEM TO calculationPassiveBalanceSheet
        $shareCapitalOrIndividual = 250;
        $convertibleBonds = 240;
        $otherBonds = 230;
        $loanAndDebtsWihCreditInstitutions = 220;
        $borrowingAndOtherFinancialDebts = 210;
        $AdvancesAndDownPaymentReceived = 200;
        $tradePayableAndRelatedAccounts = 190;
        $taxAndSocialDebts = 180;
        $debtsOnFixedAssetsAndRelatedAccount = 170;
        $otherDebts = 160;
        $prepaidIncome = 150;
        $premiumIssueMergerContribution = 140;
        $revaluationDifferences = 130;
        $legalReserve = 120;
        $statutoryOrContractualReserves = 110;
        $regulatedReserves = 100;
        $otherReserves = 0;
        $reportAgain = 90;
        $yearProfit = 80;
        $investmentGrant = 70;
        $regulatedProvisions = 60;
        $proceedsFromEquitySecuritiesIssues = 50;
        $conditionedAdvances = 40;
        $riskProvision = 30;
        $expensesProvision = 20;
        $liabilitiesTranslationDifferences = 10;

        return $lastYearPassiveBalanceSheet = $this->calculationPassiveBalanceSheet(
            $shareCapitalOrIndividual,
            $premiumIssueMergerContribution,
            $revaluationDifferences,
            $legalReserve,
            $statutoryOrContractualReserves,
            $regulatedReserves,
            $otherReserves,
            $reportAgain,
            $yearProfit,
            $investmentGrant,
            $regulatedProvisions,
            $proceedsFromEquitySecuritiesIssues,
            $conditionedAdvances,
            $riskProvision,
            $expensesProvision,
            $convertibleBonds,
            $otherBonds,
            $loanAndDebtsWihCreditInstitutions,
            $borrowingAndOtherFinancialDebts,
            $AdvancesAndDownPaymentReceived,
            $tradePayableAndRelatedAccounts,
            $taxAndSocialDebts,
            $debtsOnFixedAssetsAndRelatedAccount,
            $otherDebts,
            $prepaidIncome,
            $liabilitiesTranslationDifferences
        );
    }


    private function calculationPassiveBalanceSheet(
        $shareCapitalOrIndividual,
        $premiumIssueMergerContribution,
        $revaluationDifferences,
        $legalReserve,
        $statutoryOrContractualReserves,
        $regulatedReserves,
        $otherReserves,
        $reportAgain,
        $yearProfit,
        $investmentGrant,
        $regulatedProvisions,
        $proceedsFromEquitySecuritiesIssues,
        $conditionedAdvances,
        $riskProvision,
        $expensesProvision,
        $convertibleBonds,
        $otherBonds,
        $loanAndDebtsWihCreditInstitutions,
        $borrowingAndOtherFinancialDebts,
        $AdvancesAndDownPaymentReceived,
        $tradePayableAndRelatedAccounts,
        $taxAndSocialDebts,
        $debtsOnFixedAssetsAndRelatedAccount,
        $otherDebts,
        $prepaidIncome,
        $liabilitiesTranslationDifferences
    ) {
        //TODO RETURN CALCULATION TABLE TO actualYearPassiveBalanceSheet
        //TODO RETURN CALCULATION TABLE TO lastYearPassiveBalanceSheet

        $totalOwnCapital = $this->totalOwnCapital(
            $shareCapitalOrIndividual,
            $premiumIssueMergerContribution,
            $revaluationDifferences,
            $legalReserve,
            $statutoryOrContractualReserves,
            $regulatedReserves,
            $otherReserves,
            $reportAgain,
            $yearProfit,
            $investmentGrant,
            $regulatedProvisions
        );
        $totalOtherOwnCapital = $this->totalOtherOwnCapital($proceedsFromEquitySecuritiesIssues, $conditionedAdvances);
        $totalProvisionForRiskAndCharges = $this->totalProvisionForRiskAndCharges($riskProvision, $expensesProvision);
        $totalDebts = $this->totalDebts(
            $convertibleBonds,
            $otherBonds,
            $loanAndDebtsWihCreditInstitutions,
            $borrowingAndOtherFinancialDebts,
            $AdvancesAndDownPaymentReceived,
            $tradePayableAndRelatedAccounts,
            $taxAndSocialDebts,
            $debtsOnFixedAssetsAndRelatedAccount,
            $otherDebts,
            $prepaidIncome
        );
        $totalGeneralPassiveBalanceSheet = $this->totalGeneralPassiveBalanceSheet(
            $totalOwnCapital,
            $totalOtherOwnCapital,
            $totalProvisionForRiskAndCharges,
            $totalDebts,
            $liabilitiesTranslationDifferences
        );

        return $calculationPassiveBalanceSheet =[
            "shareCapitalOrIndividual" => $shareCapitalOrIndividual,
            "premiumIssueMergerContribution" => $premiumIssueMergerContribution,
            "revaluationDifferences" => $revaluationDifferences,
            "legalReserve" => $legalReserve,
            "statutoryOrContractualReserves" => $statutoryOrContractualReserves,
            "regulatedReserves" => $regulatedReserves,
            "otherReserves" => $otherReserves,
            "reportAgain" => $reportAgain,
            "yearProfit" =>$yearProfit,
            "investmentGrant" => $investmentGrant,
            "regulatedProvisions" => $regulatedProvisions,
            "proceedsFromEquitySecuritiesIssues" => $proceedsFromEquitySecuritiesIssues,
            "conditionedAdvances" => $conditionedAdvances,
            "riskProvision" => $riskProvision,
            "expensesProvision" => $expensesProvision,
            "convertibleBonds" => $convertibleBonds,
            "otherBonds" => $otherBonds,
            "loanAndDebtsWihCreditInstitutions" => $loanAndDebtsWihCreditInstitutions,
            "borrowingAndOtherFinancialDebts" => $borrowingAndOtherFinancialDebts,
            "AdvancesAndDownPaymentReceived" => $AdvancesAndDownPaymentReceived,
            "tradePayableAndRelatedAccounts" => $tradePayableAndRelatedAccounts,
            "taxAndSocialDebts" => $taxAndSocialDebts,
            "debtsOnFixedAssetsAndRelatedAccount" => $debtsOnFixedAssetsAndRelatedAccount,
            "otherDebts" => $otherDebts,
            "prepaidIncome" => $prepaidIncome,
            "liabilitiesTranslationDifferences" =>$liabilitiesTranslationDifferences,
            "totalOwnCapital" => $totalOwnCapital,
            "totalOtherOwnCapital" => $totalOtherOwnCapital,
            "totalProvisionForRiskAndCharges" => $totalProvisionForRiskAndCharges,
            "totalDebts" => $totalDebts,
            "totalGeneralPassiveBalanceSheet" => $totalGeneralPassiveBalanceSheet
            ];
    }


    //function use by calculationActiveBalanceSheet


    private function totalFixedAsset(
        $administrationFees,
        $researchAndDevelopmentCost,
        $concessionPatentsAndSimilar,
        $commercialFund,
        $otherIntangibleAsset,
        $advancesAndDownPaymentOnIntangibleAssets,
        $grounds,
        $constructions,
        $technicalInstallationsEquipment,
        $otherTangibleFixedAssets,
        $advancesAndDownPaymentOnTangibleAssets,
        $investmentsAccountedForEquityMethod,
        $otherParticipations,
        $receivablesRelatedEquityInvestments,
        $otherLockedSecurities,
        $loans,
        $otherFinancialAssets
                                        ) {
        return $totalFixedAsset =
                        $administrationFees +
                        $researchAndDevelopmentCost +
                        $concessionPatentsAndSimilar +
                        $commercialFund +
                        $otherIntangibleAsset +
                        $advancesAndDownPaymentOnIntangibleAssets +
                        $grounds +
                        $constructions +
                        $technicalInstallationsEquipment +
                        $otherTangibleFixedAssets +
                        $advancesAndDownPaymentOnTangibleAssets +
                        $investmentsAccountedForEquityMethod +
                        $otherParticipations +
                        $receivablesRelatedEquityInvestments +
                        $otherLockedSecurities +
                        $loans +
                        $otherFinancialAssets;
    }

    private function totalActiveCirculating(
        $rowMaterialsSupplies,
        $outstandingProducingGoods,
        $outstandingServices,
        $intermediateAndFinishProduct,
        $merchandise,
        $advancesAndPrepaymentOrders,
        $customersAndRelatedAccounts,
        $otherReceivables,
        $subscribedAndCallCapitalUnpaid,
        $marketableSecurities,
        $bank,
        $availability,
        $prepaidExpenses
                                            ) {
        return $totalActiveCirculating = $rowMaterialsSupplies +
                                            $outstandingProducingGoods +
                                            $outstandingServices+
                                            $intermediateAndFinishProduct +
                                            $merchandise +
                                            $advancesAndPrepaymentOrders+
                                            $customersAndRelatedAccounts+
                                            $otherReceivables+
                                            $subscribedAndCallCapitalUnpaid+
                                            $marketableSecurities+
                                            $bank+
                                            $availability+
                                            $prepaidExpenses;
    }


    private function totalGeneralActiveBalanceSheet(
        $subscribedCapitalNotCall,
        $totalFixedAsset,
        $totalActiveCirculating,
        $expensesSpreadOverSeveralFinancialYears,
        $bondRepaymentPremiums,
        $activeConversionDifferences
                                                    ) {
        return $totalGeneralActiveBalanceSheet =    $subscribedCapitalNotCall+
                                                    $totalFixedAsset+
                                                    $totalActiveCirculating+
                                                    $expensesSpreadOverSeveralFinancialYears+
                                                    $bondRepaymentPremiums+
                                                    $activeConversionDifferences;
    }


    //function use by calculationPassiveBalanceSheet

    private function totalOwnCapital(
        $shareCapitalOrIndividual,
        $premiumIssueMergerContribution,
        $revaluationDifferences,
        $legalReserve,
        $statutoryOrContractualReserves,
        $regulatedReserves,
        $otherReserves,
        $reportAgain,
        $yearProfit,
        $investmentGrant,
        $regulatedProvisions
    ) {
        return $totalOwnCapital =  $shareCapitalOrIndividual+
                                    $premiumIssueMergerContribution+
                                    $revaluationDifferences+
                                    $legalReserve+
                                    $statutoryOrContractualReserves+
                                    $regulatedReserves+
                                    $otherReserves+
                                    $reportAgain+
                                    $yearProfit+
                                    $investmentGrant+
                                    $regulatedProvisions;
    }

    private function totalOtherOwnCapital($proceedsFromEquitySecuritiesIssues, $conditionedAdvances)
    {
        return $totalOtherOwnCapital = $proceedsFromEquitySecuritiesIssues + $conditionedAdvances;
    }

    private function totalProvisionForRiskAndCharges($riskProvision, $expensesProvision)
    {
        return $totalProvisionForRiskAndCharges = $riskProvision + $expensesProvision;
    }

    private function totalDebts(
        $convertibleBonds,
        $otherBonds,
        $loanAndDebtsWihCreditInstitutions,
        $borrowingAndOtherFinancialDebts,
        $AdvancesAndDownPaymentReceived,
        $tradePayableAndRelatedAccounts,
        $taxAndSocialDebts,
        $debtsOnFixedAssetsAndRelatedAccount,
        $otherDebts,
        $prepaidIncome
    ) {
        return $totalDebts =    $convertibleBonds+
                                $otherBonds+
                                $loanAndDebtsWihCreditInstitutions+
                                $borrowingAndOtherFinancialDebts+
                                $AdvancesAndDownPaymentReceived+
                                $tradePayableAndRelatedAccounts+
                                $taxAndSocialDebts+
                                $debtsOnFixedAssetsAndRelatedAccount+
                                $otherDebts+
                                $prepaidIncome;
    }

    private function totalGeneralPassiveBalanceSheet(
        $totalOwnCapital,
        $totalOtherOwnCapital,
        $totalProvisionForRiskAndCharges,
        $totalDebts,
        $liabilitiesTranslationDifferences
    ) {
        return $totalGeneralPassiveBalanceSheet =        $totalOwnCapital+
                                                         $totalOtherOwnCapital+
                                                         $totalProvisionForRiskAndCharges+
                                                         $totalDebts+
                                                         $liabilitiesTranslationDifferences;
    }
}
