<?php
namespace Kwizer\CustomFormBundle\Entity;

use Kwizer\CustomFormBundle\Model\FieldInterface;
use Kwizer\CustomFormBundle\Model\FieldTypeInterface;

/**
 * @ORM\MappedSuperclass
 * @author kwizer
 *
 */
abstract class Field implements FieldInterface
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
	 * The options of the field 
	 * @var array
	 */
	private $options;
	
	/**
	 * Default value
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
	 * {@inheritdoc}
	 */
	public function getTitle()
	{
		return $this->title;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getFieldType()
	{
		return $this->fieldType;
	}
	
	/**
	 * {@inheritdoc}
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