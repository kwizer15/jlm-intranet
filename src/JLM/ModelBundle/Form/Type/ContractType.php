<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('door','door_hidden')
        	->add('trustee','trustee_select',array('label'=>'Syndic'))
            ->add('number',null,array('label'=>'Numéro'))
            ->add('complete','choice',array('label'=>'Type','choices'=>array('0'=>'Normal','1'=>'Complet'),'attr'=>array('class'=>'input-small')))
            ->add('option',null,array('label'=>'Option','attr'=>array('class'=>'input-mini')))
            ->add('begin','datepicker',array('label'=>'Début du contrat'))		
            ->add('endWarranty','datepicker',array('label'=>'Fin de garantie','required'=>false))           
            ->add('fee','money',array('label'=>'Redevance annuelle','attr'=>array('class'=>'input-small')))
            
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
