<?php
namespace Kwizer\CustomFormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kwizer\CustomFormBundle\Entity\FieldList;

class FieldListType extends AbstractType
{
	private $fields;
	
	/**
	 * Constructor
	 *
	 * @param FieldInterface $field
	 */
	public function __construct(FieldList $fields)
	{
		$this->fields = $fields;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		foreach ($this->fields as $field)
		{
		//	$field->addOption('label', $field->getTitle());
			$builder->add($field->getTitle(), $field->getFieldType()->getFormTypeName(), $field->getOptions());
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'kwizer_customformbundle_fieldlist';
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'virtual' => true,
		));
	}
}