<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('street',null,array('label'=>'Adresse','attr'=>array('placeholder'=>'Adresse','class'=>'input-xlarge')))
            ->add('city','city_select' ,array('label'=>'Ville','attr'=>array('placeholder'=>'Ville','class'=>'typeahead input-xlarge'))); 
        ;
    }

    public function getName()
    {
        return 'address';
    }
    
	public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'JLM\ModelBundle\Entity\Address',
        );
    }
}
