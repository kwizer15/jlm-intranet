<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DoorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        	->add('type',new DoorTypeType)
        	->add('address','address')
        	->add('location','text')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_doortype';
    }
}
