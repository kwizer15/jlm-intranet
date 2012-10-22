<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DoorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        	->add('type',null,array('label'=>'Type de porte'))
        	->add('address','address',array('label'=>'Adresse'))
        	->add('location','text',array('label'=>'Localisation'))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_doortype';
    }
}
