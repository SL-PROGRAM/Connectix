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
use Symfony\Component\Security\Core\Role\Role;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => 'form.user.firstName'
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => 'form.user.lastName'
            ])
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'The Email fields must match.',
                'options' => ['attr' => ['class' => 'email-field']],
                'required' => true,
                'first_options'  => ['label' => 'form.user.email'],
                'second_options' => ['label' => 'form.user.repeatEmail'],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'form.user.password'],
                'second_options' => ['label' => 'form.user.repeatPassword'],
            ])
             ->add('roles', ChoiceType::class, array(
                 'label' => 'form.user.roles',
                'attr'  =>  ['class' => 'form-control',
                    'style' => 'margin:5px 0;'],
                'choices' => [
                        'form.user.role1' => [
                        'form.user.drh' => 'DIRECTOR_HUMAN_RESSOURCES',
                        'form.user.dprod' => "TECHNIC_DIRECTOR",
                        'form.user.dsales' => "COMMERCIAL_DIRECTOR",
                        'form.user.dmark' => "MARKETING_DIRECTOR",
                        'form.user.dfin' => "FINANCIAL_DIRECTOR",
                        'form.user.dval' => "VALIDATION_DIRECTOR",
                    ],
                    'form.user.role2' => [
                        'form.user.dprodsales' => "TECHNIC_COMMERCIAL_DIRECTOR",
                        'form.user.dfinmark' => "FINANCIAL_MARKETING_DIRECTOR",
                        'form.user.valmark' => "VALIDATION_MARKETING_DIRECTOR",
                        'form.user.valdrh' => "VALIDATION_HUMAN_RESSOURCE_DIRECTOR",
                    ],
                    'form.user.role3' => [
                        'form.user.dgfin' => "GENERAL_FINANCIAL_DIRECTOR",
                        'form.user.dgh' => "EXCLUSIVE_DIRECTOR",
                    ],
                    'form.user.role4' => [
                        'form.user.gerant' => "PRESIDENT",
                    ],
                ]
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
