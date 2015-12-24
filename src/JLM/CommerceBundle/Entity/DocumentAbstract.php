<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Entity;

use JLM\CommerceBundle\Model\AskPriceInterface;
use JLM\CommerceBundle\Model\EventFollowerInterface;
use JLM\CommerceBundle\Model\EventInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\CommerceBundle\Model\DocumentInterface;
use JLM\CommerceBundle\Model\DocumentLineInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class DocumentAbstract implements DocumentInterface
{
	/**
	 * Date création
	 * @var \DateTime
	 */
	private $creation;
	
	/**
	 * Numéro du document
	 * @var int
	 */
	private $number;
	
	/**
	 * Suivi d'évenements
	 * @var EventFollowerInterface
	 */
	private $eventFollower;
	
	/**
	 * Lignes de document
	 */
	private $lines;
	
	/**
	 * Constructeur
	 */
	public function __construct()
	{
		$this->lines = new ArrayCollection();
		$this->setEventFollower(new EventFollower()); // @todo change to create
	}
	

	/**
	 * Set creation
	 *
	 * @param \DateTime $creation
	 * @return self
	 */
	public function setCreation(\DateTime $creation)
	{
		$this->creation = $creation;
	
		return $this;
	}
	
	/**
	 * Get creation
	 *
	 * @return \DateTime
	 */
	public function getCreation()
	{
		return $this->creation;
	}
	

	/**
	 * Set number
	 *
	 * @param integer $number
	 * @return self
	 */
	public function setNumber($number)
	{
		$this->number = $number;
	
		return $this;
	}
	
	/**
	 * Get number
	 *
	 * @return integer
	 */
	public function getNumber()
	{
		return $this->number;
	}
	
	/**
	 * Add lines
	 *
	 * @param QuoteLineInterface $line
	 * @return bool
	 */
	public function addLine(DocumentLineInterface $line)
	{
		$this->lines->add($line);
			
		return $this;
	}
	
	/**
	 * Remove lines
	 *
	 * @param QuoteLineInterface $line
	 */
	public function removeLine(DocumentLineInterface $line)
	{
		return $this->lines->removeElement($line);
	}
	
	/**
	 * Get lines
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getLines()
	{
		return $this->lines;
	}
	
	/**
	 *
	 * @param EventInterface $event
	 * @return bool
	 */
	public function addEvent($event, $options = array())
	{
		if (!$event instanceof Event)
		{
			$name = $event;
			$event = new Event(); // @todo change to create
			$event->setName($name);
			$event->setOptions($options);
		}
		 
		return $this->getEventFollower()->addEvent($event);
	}
	
	/**
	 *
	 * @param EventInterface $event
	 * @return bool
	 */
	public function removeEvent(EventInterface $event)
	{
		return $this->getEventFollower()->removeEvent($event);
	}
	
	/**
	 * 
	 * @return multitype:
	 */
	public function getEvents()
	{
		return $this->getEventFollower()->getEvents();
	}
	
	/**
	 * 
	 * @param unknown $name
	 */
	public function getLastEvent($name)
	{
		return $this->getEventFollower()->getLastEvent($name);
	}
	
	/**
	 *
	 * @return EventFollowerInterface
	 */
	public function getEventFollower()
	{
		if ($this->eventFollower === null)
		{
			$this->setEventFollower(new EventFollower()); // @todo change to create
		}
		 
		return $this->eventFollower;
	}
	
	/**
	 *
	 * @param EventFollowerInterface $eventFollower
	 * @return self
	 */
	public function setEventFollower(EventFollowerInterface $eventFollower)
	{
		$this->eventFollower = $eventFollower;
	
		return $this;
	}
}