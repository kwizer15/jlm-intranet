<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        	->add('trustee','trustee_select',array('label'=>'Syndic'))
            ->add('number',null,array('label'=>'Numéro'))
            ->add('type','choice',array('label'=>'Type'))
            ->add('begin','date')		
            ->add('endWarranty','date')	
            ->add('end','date')            
            ->add('turnover','money',array('label'=>'CA'))
            ->add('door',new ContractDoorType,array('label'=>'Porte'))
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
