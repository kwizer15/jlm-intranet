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
            ->add('city',new TypeaheadType,array('class'=>'JLMModelBundle:City','label'=>'Ville'))
            ->add('billing','checkbox',array('label'=>'Adresse de facturation','required'=>false))
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
