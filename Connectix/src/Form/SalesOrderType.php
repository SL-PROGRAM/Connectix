<?php

namespace App\Form;

use App\Entity\SalesOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalesOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('turn')
            ->add('status')
            ->add('salesPrice')
            ->add('productQuantitySales')
            ->add('salesActivityCost')
            ->add('socity')
            ->add('product')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SalesOrder::class,
        ]);
    }
}
