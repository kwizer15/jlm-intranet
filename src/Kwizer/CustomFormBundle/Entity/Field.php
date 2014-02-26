<?php
namespace Kwizer\CustomFormBundle\Entity;

use Kwizer\CustomFormBundle\Model\FieldInterface;
use Kwizer\CustomFormBundle\Model\FieldTypeInterface;

/**
 * @ORM\MappedSuperclass
 * @author kwizer
 *
 */
class Field implements FieldInterface
{
	/**
	 * The title
	 * @var string
	 */
	private $title;
	
	/**
	 * The field type
	 * @var FieldTypeInterface
	 */
	private $fieldType;
	
	/**
	 *
	 * @var array
	 */
	private $options;
	
	/**
	 * 
	 * @var mixed
	 */
	private $defaultValue;
	
	/**
	 * 
	 * @param unknown $title
	 * @param FieldTypeInterface $fieldType
	 * @param unknown $options
	 */
	public function __construct($title, FieldTypeInterface $fieldType, $options = array())
	{
		$this->title = $title;
		$this->fieldType = $fieldType;
		$this->options = $options;
	}
	
	/**
	 * Get the name
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}
	
	/**
	 * Get the field type
	 * 
	 * @return FieldTypeInterface
	 */
	public function getFieldType()
	{
		return $this->fieldType;
	}
	
	/**
	 * Get the field type
	 *
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getDefaultValue()
	{
		return $this->defaultValue;
	}
}