<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Socity;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'The Email fields must match.',
                'options' => ['attr' => ['class' => 'email-field']],
                'required' => true,
                'first_options'  => ['label' => 'Email'],
                'second_options' => ['label' => 'Repeat Email'],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
             ->add('roles', ChoiceType::class, array(
                'attr'  =>  array('class' => 'form-control',
                'style' => 'margin:5px 0;'),
                'choices' =>
                array
                (
                        'DRH' => 'DIRECTOR_HUMAN_RESSOURCES',
                        'Directeur de production' => 'TECHNIC_DIRECTOR',
                        'Directeur Commercial' => 'COMMERCIAL_DIRECTOR',
                        'Directeur Marketing' => 'MARKETING_DIRECTOR',
                        'Directeur Financier' => 'FINANCIAL_DIRECTOR',
                        'Directeur d\'entreprise' => 'VALIDATION_DIRECTOR',
                        'Directeur de production et commerce' => 'TECHNIC_COMMERCIAL_DIRECTOR',
                        'Directeur Financier et marketing' => 'FINANCIAL_MARKETING_DIRECTOR',
                        'Directeur du marketing et d\'entreprise' => 'VALIDATION_MARKETING_DIRECTOR',
                        'DRH et Directeur d\'entreprise' => 'VALIDATION_HUMAN_RESSOURCE_DIRECTOR',
                        'Directeur Financier, marketing et d\'entreprise' => 'GENERAL_FINANCIAL_DIRECTOR',
                        'Directeur RH, production et Commerce' => 'EXCLUSIVE_DIRECTOR',
                        'Gérant unique' => 'PRESIDENT',

                )
                ,
                'multiple' => false,
                'required' => true,
                ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
