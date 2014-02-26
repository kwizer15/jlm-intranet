<?php
namespace Kwizer\CustomFormBundle\Entity;

class Concrete
{
	private $type;
	
	private $id;
	
	private $fieldValues;
	
	public function __construct($id, ConcreteType $type)
	{
		$this->setId($id);
		$this->setType($type);
		
	}
	
	public function setType(ConcreteType $type)
	{
		$this->type = $type;
		
		$this->fieldValues = array();
		$fields = $this->type->getFields();
		foreach ($fields as $field)
		{
			$options = $field->getOptions();
			if (is_array($options))
			{
				if (array_key_exists('value', $options))
				{
					$this->fieldValues[$field->getTitle()] = $options['value'];
				}
				else 
				{
					$this->fieldValues[$field->getTitle()] = null;
				}
			}
		}
		
		return $this;
	}
	
	public function setId($id)
	{
		$this->id = $id;
		
		return $this;
	}
	
	public function __get($attr)
	{
		
		if (!array_key_exists($attr, $this->fieldValues))
			throw new \Exception('L\'attribut "'.$attr.'" n\'existe pas');
		return $this->fieldValues[$attr];
	}
	
	public function __call($name, $arguments)
	{
		if (substr($name, 0, 3) == 'set')
		{ 
			$attr = strtolower(substr($name, 3));
			if (!in_array($attr, $this->type->getFields()))
			{
				throw new \Exception('L\'attribut "'.$attr.'" n\'existe pas');
			}
			if (count($arguments) != 1)
			{
				throw new \Exception('Nombre d\'arguments incorrect');
			}
			$this->fieldValues[$attr] = $arguments;
		}
		elseif (substr($name, 0, 3) == 'get')
		{ 
			$attr = strtolower(substr($name, 3));
			if (!in_array($attr, $this->type->getFields()))
			{
				throw new \Exception('L\'attribut "'.$attr.'" n\'existe pas');
			}
			return $this->fieldValues[$attr];
		}
		
		throw new \Exception('Methode inconnue');
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getTypeName()
	{
		return $this->getType()->getName();
	}
}
