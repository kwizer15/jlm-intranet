<?php
namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatepickerType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver
			->setDefaults(array(
				'widget' => 'single_text',
				'format'=>'dd/MM/yyyy',
				'years'  => range(date('Y') - 5, date('Y') + 5),
				'attr'=>array('class'=>'input-small datepicker')
		));
	}

	public function getParent()
	{
		return 'genemu_jquerydate';
	}

	public function getName()
	{
		return 'datepicker';
	}
}