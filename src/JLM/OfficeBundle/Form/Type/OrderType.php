<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('work', 'intervention_hidden')
            ->add('time', null, ['label' => 'Temps prévu'])
            ->add(
                'lines',
                'collection',
                ['prototype' => true, 'allow_add' => true, 'allow_delete' => true, 'type' => 'order_line']
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\OfficeBundle\Entity\Order']);
    }

    public function getName()
    {
        return 'order';
    }
}
