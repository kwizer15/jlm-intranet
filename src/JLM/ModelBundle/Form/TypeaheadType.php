<?php
namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TypeaheadType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
    {
    	$builder
    		->add('id','hidden')
    		->add('search','text',array('attr'=>array('class'=>'typeahead')))
    	;
	}
	
//	public function buildForm(FormBuilder $builder, array $options)
//	{
//		$builder
//			->add('id','hidden')
//			->add('value',null,array('widget'=>'single_text','attr'=>array('class'=>'typeahead')))
//		;
//	}

	public function getParent(array $options)
	{
		return 'form';
	}
	
	public function getName()
	{
		return 'typeahead';
	}
}