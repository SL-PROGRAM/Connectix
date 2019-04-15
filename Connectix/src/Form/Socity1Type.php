<?php

namespace App\Form;

use App\Entity\Socity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Socity1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
//            ->add('priceMinPublicicyImpact')
//            ->add('priceMaxPublicityImpact')
//            ->add('playerNumber')
//            ->add('game')
        ;

        $builder->add('users', CollectionType::class, [
            'entry_type' => UserType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
        ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Socity::class,
        ]);
    }
}
