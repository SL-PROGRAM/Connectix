<?php

namespace App\Form;

use App\Entity\SalesManParticular;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalesManParticularType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('salary')
            ->add('formation')
            ->add('exprience')
            ->add('productivity')
            ->add('administrationActivityCost')
            ->add('coeficientSalary')
            ->add('commission')
            ->add('salesActivity')
            ->add('salesActivityParticular')
            ->add('socity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SalesManParticular::class,
        ]);
    }
}
