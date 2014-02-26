<?php
namespace Kwizer\CustomFormBundle\Entity;

class ConcreteField extends Field
{
	private $concreteType;
	
	public function getConcreteType()
	{
		return $this->concreteType;
	}
	
	public function setConcreteType(ConcreteType $concreteType)
	{
		$this->concreteType = $concreteType;
		
		return $this;
	}
	
}