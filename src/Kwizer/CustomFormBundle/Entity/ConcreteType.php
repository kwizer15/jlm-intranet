<?php
namespace Kwizer\CustomFormBundle\Entity;

use Kwizer\CustomFormBundle\Model\FieldListInterface;
use Kwizer\CustomFormBundle\Model\FieldInterface;

class ConcreteType extends CustomizableType
{
	private $id;
	
	private $name;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function __construct($id, $name, $fields = array())
	{
		$this->setName($name);
		$this->setId($id);
		foreach ($fields as $field)
		{
			if ($field instanceof ConcreteField)
			{
				$this->addField($field);
			}
		}
	}

	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}
	
	public function setId($id)
	{
		$this->id = $id;
		
		return $this;
	}
}