<?php

namespace App\Form;

use App\Entity\ReseachOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReseachOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reseachDo')
            ->add('researchActivityCost')
            ->add('administrationActivityCost')
            ->add('socity')
            ->add('product')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReseachOrder::class,
        ]);
    }
}
