<?php

namespace App\Form;

use App\Entity\ProductionOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductionOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('turn')
            ->add('status')
            ->add('quantityProductCreat')
            ->add('productionActivityCost')
            ->add('administrationActivityCost')
            ->add('productionTime')
            ->add('rowMaterialCost')
            ->add('product')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductionOrder::class,
        ]);
    }
}
