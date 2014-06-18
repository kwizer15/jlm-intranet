<?php
namespace Kwizer\CustomFormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kwizer\CustomFormBundle\Model\FieldInterface;

class FieldType extends AbstractType
{
	private $field;
	
	/**
	 * Constructor
	 * 
	 * @param FieldInterface $field
	 */
	public function __construct(FieldInterface $field)
	{
		$this->field = $field;
	}

	/**
	 * 
	 * @return string
	 */
	public function getParent()
	{
		return $this->field->getFieldType()->getFormTypeName();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return $this->field->getTitle();
	}
}