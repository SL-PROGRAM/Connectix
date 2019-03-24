<?php

namespace App\Form;

use App\Entity\Technician;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnicianType extends AbstractType
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
            ->add('productionActivity')
            ->add('administrationActivity')
            ->add('socity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Technician::class,
        ]);
    }
}
