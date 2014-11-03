<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContractStopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('end','datepicker',array('label'=>'Fin du contrat','required'=>false))		
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_contractstoptype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'JLM\ContractBundle\Entity\Contract',
    	);
    }
}
