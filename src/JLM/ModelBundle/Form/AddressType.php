<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('street',null,array('label'=>'Adresse'))
            ->add('city',null,array('label'=>'Ville'))
            ->add('billing',null,array('label'=>'Adresse de facturation'))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_addresstype';
    }
    
	public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'JLM\ModelBundle\Entity\Address',
        );
    }
}
