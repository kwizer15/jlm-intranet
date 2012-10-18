<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EmailType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('email','email',array('label'=>'e-mail','attr'=>array('class'=>'input-xxlarge','placeholder'=>'adresse e-mail')));
            
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_emailtype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'JLM\ModelBundle\Entity\Email',
    	);
    }
}
