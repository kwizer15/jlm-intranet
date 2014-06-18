<?php
namespace Kwizer\CustomFormBundle\Entity;

class Concrete extends Customizable
{
	private $id;
	
	public function __construct($id, ConcreteType $type)
	{
		$this->setId($id);
		$this->setType($type);	
	}
	
	public function setId($id)
	{
		$this->id = $id;
		
		return $this;
	}
	
	public function getId()
	{
		return $this->id;
	}
}
