<?php
namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TypeaheadType extends AbstractType
{

	public function getDefaultOptions(array $options)
	{
		return array(
				'widget'=>'text',
		);
	}
	
	public function getParent(array $options)
	{
		return 'entity';
	}
	
	public function getName()
	{
		return 'typeahead';
	}
}