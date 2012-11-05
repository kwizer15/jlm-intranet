<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DistanceType extends AbstractType
{
    public function getParent()
    {
    	return 'text';
    }
    
    public function getName()
    {
        return 'distance';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'invalid_message' => 'Distance invalde',
    			'attr'=>array('class'=>'input-mini'),
    	));
    }
}
