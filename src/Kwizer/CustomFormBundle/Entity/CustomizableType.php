<?php
namespace Kwizer\CustomFormBundle\Entity;

use Kwizer\CustomFormBundle\Model\FieldInterface;
use Kwizer\CustomFormBundle\Model\CustomizableTypeInterface;

/**
 * @ORM\MappedSuperclass
 * @author kwizer
 *
 */
abstract class CustomizableType implements CustomizableTypeInterface
{
	private $fields;
	
	public function getFields()
	{
		return $this->fields;
	}
	
	public function addField(FieldInterface $field)
	{
		$this->fields[] = $field;
		
		return $this;
	}
}