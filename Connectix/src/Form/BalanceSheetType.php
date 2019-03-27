<?php

namespace App\Form;

use App\Entity\BalanceSheet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BalanceSheetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('turn')
            ->add('status')
            ->add('administationActivityCapacity')
            ->add('salesActivityCapacity')
            ->add('researchActivityCapacity')
            ->add('salesActivityProfessionalCapacity')
            ->add('salesActivityParticularCapacity')
            ->add('productionActivityCapacity')
            ->add('marchendiseSales')
            ->add('productionSales')
            ->add('productionStock')
            ->add('merchandiseStock')
            ->add('totalSalary')
            ->add('rawPurchase')
            ->add('marchendisePurchase')
            ->add('otherPurchase')
            ->add('depreciationAmortization')
            ->add('taxes')
            ->add('repaymentOnDepreciationAndProvisions')
            ->add('provisions')
            ->add('provisionOnCurrentAsset')
            ->add('otherExpenses')
            ->add('interestAndSimilarProduct')
            ->add('interestAndSimilarExpenses')
            ->add('capitalExceptionalOperatingProduct')
            ->add('capitalExceptionalExpense')
            ->add('researchAndDevelopmentCost')
            ->add('concessionPatentsAndSimilar')
            ->add('grounds')
            ->add('constructions')
            ->add('technicalInstallationsEquipment')
            ->add('customersAndRelatedAccounts')
            ->add('otherReceivables')
            ->add('availability')
            ->add('shareCapitalOrIndividual')
            ->add('premiumIssueMergerContribution')
            ->add('legalReserve')
            ->add('statutoryOrContractualReserves')
            ->add('otherReserves')
            ->add('reportAgain')
            ->add('loanAndDebtsWihCreditInstitutions')
            ->add('tradePayableAndRelatedAccounts')
            ->add('taxAndSocialDebts')
            ->add('otherDebts')
            ->add('professionalSalesPart')
            ->add('particularSalesPart')
            ->add('socity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BalanceSheet::class,
        ]);
    }
}
