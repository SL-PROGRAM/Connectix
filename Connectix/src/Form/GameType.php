<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('tva')
            ->add('maxturn')
            ->add('turn')
            ->add('socityNumber')
            ->add('smic')
            ->add('creatAt')
            ->add('salesPriceMinLvl1')
            ->add('salesPriceMinLvl2')
            ->add('salesPriceMinLvl3')
            ->add('salesPriceMinLvl4')
            ->add('salesPriceMaxLvl1')
            ->add('salesPriceMaxLvl2')
            ->add('salesPriceMaxLvl3')
            ->add('salesPriceMaxLvl4')
            ->add('productNumberMinLvl1')
            ->add('productNumberMinLvl2')
            ->add('productNumberMinLvl3')
            ->add('productNumberMinLvl4')
            ->add('productNumberMaxLvl1')
            ->add('productNumberMaxLvl2')
            ->add('productNumberMaxLvl3')
            ->add('productNumberMaxLvl4')
            ->add('percentProductAvailableMinCycleLife1')
            ->add('percentProductAvailableMinCycleLife2')
            ->add('percentProductAvailableMinCycleLife3')
            ->add('percentProductAvailableMinCycleLife4')
            ->add('percentProductAvailableMaxCycleLife1')
            ->add('percentProductAvailableMaxCycleLife2')
            ->add('percentProductAvailableMaxCycleLife3')
            ->add('percentProductAvailableMaxCycleLife4')
            ->add('productQualityMinCycleLife1')
            ->add('productQualityMinCycleLife2')
            ->add('productQualityMinCycleLife3')
            ->add('productQualityMinCycleLife4')
            ->add('productQualityMaxCycleLife1')
            ->add('productQualityMaxCycleLife2')
            ->add('productQualityMaxCycleLife3')
            ->add('productQualityMaxCycleLife4')
            ->add('taxTurnover')
            ->add('employerContributions')
            ->add('payTax')
            ->add('variableExternalCharges')
            ->add('rowMaterialCost')
            ->add('rawMaterialMin')
            ->add('rawMaterialMax')
            ->add('manPowerMin')
            ->add('manPowerMax')
            ->add('productionTimeMin')
            ->add('productionTimeMax')
            ->add('taxRate')
            ->add('employeeParticipation')
            ->add('socityStartShareCapital')
            ->add('socityStartLoanAmount')
            ->add('socityStartLoanDuration')
            ->add('socityStartLoanInterestRate')
            ->add('annualHoursWork')
            ->add('factoryCreationCost')
            ->add('factoryMaintenanceCost')
            ->add('factoryAdministrationCost')
            ->add('factoryAmortizationTurn')
            ->add('productionLignCreationCost')
            ->add('productionLignMaintenanceCost')
            ->add('productionLignAdministrationCost')
            ->add('productionLignAmortizationTurn')
            ->add('productionLignAnnualProductTime')
            ->add('productionLignTotalLifeProductTime')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
