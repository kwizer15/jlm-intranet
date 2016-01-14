<?php
namespace JLM\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('contact','jlm_contact_contact_select',array('label'=>'Contact','attr'=>array('class'=>'input-large')))
			->add('roles', 'collection', array('type'=>'choice','options'=> array(
	            'choices' => array(
	                'ROLE_MANAGER' => 'Syndic'
	            ),
	            'required'    => true,
	            'empty_value' => 'Choisir le role',
	            'empty_data'  => null
        	)))
		;
	}

	public function getParent()
	{
		return 'fos_user_registration';
	}

	public function getName()
	{
		return 'jlm_user_registration';
	}
}