<?php

namespace JLM\OfficeBundle\Form\Type;

use JLM\DailyBundle\Form\Type\InterventionHiddenType;
use JLM\OfficeBundle\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('work', InterventionHiddenType::class)
            ->add('time', TextType::class, ['label' => 'Temps prévu'])
            ->add(
                'lines',
                CollectionType::class,
                ['prototype' => true, 'allow_add' => true, 'allow_delete' => true, 'type' => 'order_line']
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => Order::class]);
    }
}
