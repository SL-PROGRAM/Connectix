<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FastGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
        ;

        $builder->add('socities', CollectionType::class, [
            'entry_type' => Socity1Type::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            'prototype_name' => 'socity',
            'by_reference' => false,

        ]);

//        $builder->add('users', CollectionType::class, [
//            'entry_type' => UserType::class,
//            'entry_options' => ['label' => false],
//            'allow_add' => true,
//            'by_reference' => false,
//            'allow_delete' => true,
//            'prototype' => true,
//            'prototype_name' => 'player'
//        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
