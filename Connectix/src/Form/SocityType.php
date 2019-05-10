<?php

namespace App\Form;

use App\Entity\Socity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class SocityType
 * @package App\Form
 */
class SocityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'form.socity.name',
            ])
        ;

        $builder->add('users', CollectionType::class, [
            'entry_type' => UserType::class,
            'entry_options' => ['label' => false],
            'label' => false,
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            'prototype' => true,
            'prototype_name' => 'player',
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    'max' => 4096,
                ]),
          ]
        ]
    );
        $builder
        ->add('submit', SubmitType::class, [
        'label' => 'form.socity.submit.label',
    ])
        ->add('submitAndRestart', SubmitType::class, [
            'label' => 'form.socity.submitAndRestart.label',
        ])
    ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Socity::class,
        ]);
    }
}
