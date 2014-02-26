<?php
namespace Kwizer\CustomFormBundle\Entity;

use Kwizer\CustomFormBundle\Model\FieldListInterface;
use Kwizer\CustomFormBundle\Model\FieldInterface;

class ConcreteType
{
	private $id;
	
	private $name;
	
	private $fields;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getFields()
	{
		return $this->fields;
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
	
	public function addField(ConcreteField $field)
	{
		$this->fields[] = $field;
		
		return $this;
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