<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name' , TextType::class,[
            'label' => 'form.game.name'
            ])
            ->add('tva', NumberType::class,[
                'label' => 'form.game.tva'
            ])
            ->add('maxturn',NumberType::class,[
                'label' => 'form.game.maxturn'
            ])
            ->add('smic',NumberType::class,[
                'label' => 'form.game.smic'
            ])
//            ->add('salesPriceMin',NumberType::class,[
//                'label' => 'form.game.salespricemin'
//            ])
//            ->add('salesPriceMax',NumberType::class,[
//                'label' => 'form.game.salespricemax'
//            ])
            ->add('productNumberMin',NumberType::class,[
                'label' => 'form.game.numbermin'
            ])
            ->add('productNumberMax',NumberType::class,[
                'label' => 'form.game.numbermax'
            ])
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
            ->add('groundCost')
            ->add('salaryContributions')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
