<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('trustee','trustee_select',array('label'=>'Syndic'))
            ->add('number',null,array('label'=>'Numéro'))
            ->add('type',null,array('label'=>'Type','attr'=>array('class'=>'input-mini')))
            ->add('begin','datepicker',array('label'=>'Début du contrat'))		
            ->add('endWarranty','datepicker',array('label'=>'Fin de garantie','required'=>false))           
            ->add('turnover','money',array('label'=>'CA','attr'=>array('class'=>'input-small')))
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
