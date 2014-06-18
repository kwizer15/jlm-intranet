<?php
namespace Kwizer\CustomFormBundle\Entity;

use Kwizer\CustomFormBundle\Model\FieldValueInterface;

/**
 * @ORM\MappedSuperclass
 * @author kwizer
 *
 */
abstract class FieldValue implements FieldValueInterface
{
	/**
	 * 
	 * @var string
	 */
	private $field;
	
	/**
	 * 
	 * @var mixed
	 */
	private $value;
	
	/**
	 * {@inheritdoc}
	 */
	public function getField()
	{
		return $this->field;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getValue()
	{
		return $this->value;
	}

}