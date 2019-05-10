<?php

namespace App\Form;

use App\Entity\PublicityOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PublicityOrderType
 * @package App\Form
 */
class PublicityOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('publicityPrice', NumberType::class,[
                'label' => 'form.order.publicity.price'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublicityOrder::class,
        ]);
    }
}
