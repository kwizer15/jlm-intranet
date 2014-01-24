<?php

namespace JLM\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\ContactBundle\Form\DataTransformer\ContactToIntTransformer;

class SelectContactType extends AbstractType
{
    public function getParent()
    {
    	return 'kwizer_select2modal';
    }
    
    public function getName()
    {
        return 'jlm_contact_selectcontacttype';
    }
    
	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected contact does not exist',
        	'class' => 'JLMContactBundle:Contact',
        	'attr' => array(
        			'class'=>'input-xlarge',
        		),
        	'empty_value_in_choices' => true,
        	'configs' => array(
        			'placeholder' => 'Sélectionnez un contact...',
        		),
        	)
        );
    } 
}