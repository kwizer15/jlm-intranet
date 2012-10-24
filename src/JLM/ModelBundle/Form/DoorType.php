<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DoorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('site')
        	->add('type',null,array('label'=>'Type de porte'))
        	->add('street',null,array('label'=>'Adresse'))
        	->add('location',null,array('label'=>'Localisation'))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_doortype';
    }
}
