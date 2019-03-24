<?php

namespace App\Form;

use App\Entity\ProductionLign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductionLignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('turnCreation')
            ->add('creationCost')
            ->add('maintenanceCost')
            ->add('administrationCost')
            ->add('amortizationTurn')
            ->add('annualProductTime')
            ->add('totalLifeProductTime')
            ->add('socity')
            ->add('factory')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductionLign::class,
        ]);
    }
}
