<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderLineType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('position', 'hidden')
        ->add('reference', null, ['required'=>false,'attr'=>['class'=>'input-small']])
        ->add('designation', null, ['attr'=>['class'=>'input-xxlarge']])
        ->add('quantity', null, ['attr'=>['class'=>'input-mini']])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
                'data_class' => 'JLM\OfficeBundle\Entity\OrderLine'
        ]);
    }

    public function getName()
    {
        return 'order_line';
    }
}
