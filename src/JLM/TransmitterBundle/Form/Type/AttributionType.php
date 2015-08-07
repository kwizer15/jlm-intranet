<?php

namespace JLM\TransmitterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AttributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('ask','transmitter_ask_hidden')
            ->add('creation','datepicker')
            ->add('contact')
            ->add('individual',null,array('required'=>false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\TransmitterBundle\Entity\Attribution'
        ));
    }

    public function getName()
    {
        return 'jlm_transmitterbundle_attributiontype';
    }
}
