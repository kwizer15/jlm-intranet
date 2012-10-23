<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContractDoorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('type',null,array('label'=>'Type de porte'))
        	->add('address','address',array('label'=>'Adresse'))
        	->add('location','text',array('label'=>'Localisation'))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_contractdoortype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'JLM\ModelBundle\Entity\Door',
    	);
    }
}
