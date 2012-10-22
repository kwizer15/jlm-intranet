<?php
namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

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

	public function getParent(array $options)
	{
		return 'date';
	}

	public function getName()
	{
		return 'datepicker';
	}
}