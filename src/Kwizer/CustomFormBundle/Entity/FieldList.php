<?php
namespace Kwizer\CustomFormBundle\Entity;

use Kwizer\CustomFormBundle\Model\FieldInterface;

/**
 * @ORM\MappedSuperclass
 * @author kwizer
 *
 */
class FieldList implements \IteratorAggregate
{
	/**
	 * 
	 * @var FieldInterface
	 */
	private $fields;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->fields = new \Doctrine\Common\Collections\ArrayCollection;
	}
	
	public function add(FieldInterface $field)
	{
		$this->fields->add($field);
		
		return $this;
	}
	
	public function remove(FieldInterface $field)
	{
		$this->fields->removeElement($field);
	
		return $this;
	}
	
	public function getFields()
	{
		return $this->fields;
	}
	
	public function getIterator()
	{
		return $this->fields;
	}
}