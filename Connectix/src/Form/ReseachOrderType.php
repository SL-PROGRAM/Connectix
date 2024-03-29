<?php

namespace App\Form;

use App\Entity\ReseachOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ReseachOrderType
 * @package App\Form
 */
class ReseachOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reseachDo', NumberType::class,[
                'label' => 'form.order.research.quantity'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReseachOrder::class,
        ]);
    }
}
