<?php
namespace Kwizer\CustomFormBundle\Entity;

use Kwizer\CustomFormBundle\Model\CustomizableTypeInterface;
use Kwizer\CustomFormBundle\Model\CustomizableInterface;

/**
 * @ORM\MappedSuperclass
 * @author kwizer
 *
 */
abstract class Customizable implements CustomizableInterface
{
	/**
	 * The additionnal attributes from the customizable entity
	 * @var FieldTypeInterface
	 */
	private $type;
	
	/**
	 * The values of each fields
	 * @var array
	 */
	private $fieldValues;
	
	/**
	 * {@inheritdoc}
	 */
	public function setType(CustomizableTypeInterface $type)
	{
		$this->type = $type;
	
		$this->fieldValues = array();
		$fields = $this->type->getFields();
		foreach ($fields as $field)
		{
			$options = $field->getOptions();
			if (is_array($options))
			{
				if (array_key_exists('data', $options))
				{
					$this->fieldValues[$field->getTitle()] = $options['data'];
				}
				else
				{
					$this->fieldValues[$field->getTitle()] = null;
				}
			}
		}
	
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function __get($attr)
	{
		if (!array_key_exists($attr, $this->fieldValues))
		{
			throw new \Exception('L\'attribut "'.$attr.'" n\'existe pas');
		}
		
		return $this->fieldValues[$attr];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getTypeName()
	{
		return $this->getType()->getName();
	}
}