<?php

namespace App\Form;

use App\Entity\ResearcherDirector;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResearcherDirectorType extends AbstractType
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
            ->add('researchActivity')
            ->add('administrationActivity')
            ->add('socity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ResearcherDirector::class,
        ]);
    }
}
