<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('number',null,array('label'=>'Numéro'))
            ->add('type','choice',array('label'=>'Type'))
            ->add('begin','date',array(
	            'widget' => 'single_text',
	            'format' => 'dd/MM/yyyy',
	            'attr' => array('class' => 'date'),
            	'label' => 'Date du début'		
            ))
            ->add('endWarranty','date',array(
	            'widget' => 'single_text',
	            'format' => 'dd/MM/yyyy',
	            'attr' => array('class' => 'date'),
            	'label' => 'Date de fin de garantie'		
            ))
            ->add('end','date',array(
	            'widget' => 'single_text',
	            'format' => 'dd/MM/yyyy',
	            'attr' => array('class' => 'date'),
            	'label' => 'Date de fin de contrat'		
            ))
            ->add('turnover',null,array('label'=>'CA'))
            ->add('door',new DoorType,array('label'=>'Porte'))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_contracttype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'JLM\ModelBundle\Entity\Contract',
    	);
    }
}
