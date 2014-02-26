<?php
namespace Kwizer\CustomFormBundle\Entity;

use Kwizer\CustomFormBundle\Model\FieldTypeInterface;

/**
 * @ORM\MappedSuperclass
 * @author kwizer
 *
 */
class FieldType implements FieldTypeInterface
{
	/**
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * 
	 * @var string
	 */
	private $formTypeName;
	
	
	
	public function __construct($name, $formTypeName)
	{
		$this->name = $name;
		$this->formTypeName = $formTypeName;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getFormTypeName()
	{
		return $this->formTypeName;
	}
}