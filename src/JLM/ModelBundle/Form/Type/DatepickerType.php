<?php
namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

class DatepickerType extends AbstractType
{
	public function getDefaultOptions(array $options)
	{
		return array(
	            'widget'=>'single_text',
	            'input'=>'datetime',
	            'format'=>'dd/MM/yyyy',
	            'attr'=>array('class'=>'input-small datepicker'),
            );
	}

	public function getParent()
	{
		return 'date';
	}

	public function getName()
	{
		return 'datepicker';
	}
}