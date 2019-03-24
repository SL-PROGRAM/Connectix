<?php

namespace App\Form;

use App\Entity\Factory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('turnCreation')
            ->add('creationCost')
            ->add('maintenanceCost')
            ->add('administrationCost')
            ->add('amortizationTurn')
            ->add('name')
            ->add('socity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Factory::class,
        ]);
    }
}
