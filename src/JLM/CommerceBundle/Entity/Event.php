<?php
namespace JLM\CommerceBundle\Entity;

use JLM\CommerceBundle\Model\EventInterface;

class Event implements EventInterface
{	
	/**
	 * @var \DateTime
	 */
	private $date;
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * {@inheritdoc}
	 */
	public function getDate()
	{
		return $this->date;
	}
	
	/**
	 * 
	 * @param \DateTime $date
	 * @return self
	 */
	public function setDate(\DateTime $date)
	{
		$this->date = $date;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param string $name
	 * @return self
	 */
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}
}