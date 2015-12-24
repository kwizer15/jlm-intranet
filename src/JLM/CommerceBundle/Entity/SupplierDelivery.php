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

use Doctrine\Common\Collections\ArrayCollection;
use JLM\CommerceBundle\Model\EventInterface;
use JLM\CommerceBundle\Model\EventFollowerInterface;
use JLM\CommerceBundle\Model\DeliveryLineInterface;
use JLM\CommerceBundle\Model\SupplierDeliveryInterface;
use JLM\CommerceBundle\Model\SupplierInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SupplierDelivery implements SupplierDeliveryInterface
{	
	/**
	 * @var int $id
	 */
	private $id;

	/**
	 * Reference
	 * @var string
	 */
	private $reference;

	/**
	 * Lignes
	 * @var ArrayCollection
	 */
	private $lines;

	/**
	 * @var datetime $creation
	 */
	private $creation;
	
	/**
	 * Numéro du devis
	 * @var int
	 */
	private $number;
	
	/**
	 * Bon de livraison fournisseur
	 * @var UploadDocumentInterface[]
	 */
	private $documents;
	
	/**
	 * Suivi d'évenements
	 * @var EventFollowerInterface
	 */
	private $eventFollower;
	
	/**
	 * 
	 * @var SupplierInterface
	 */
	private $supplier;
	
	public function __construct()
	{
		$this->setEventFollower(new EventFollower()); // @todo change to create
		$this->documents = new ArrayCollection();
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
	
	public function getEvents()
	{
		return $this->getEventFollower()->getEvents();
	}
	
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
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set reference
	 *
	 * @param string $reference
	 * @return Bill
	 */
	public function setReference($reference)
	{
		$this->reference = $reference;

		return $this;
	}

	/**
	 * Get reference
	 *
	 * @return string
	 */
	public function getReference()
	{
		return $this->reference;
	}
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->lines = new ArrayCollection;
	}

	/**
	 * Add lines
	 *
	 * @param BillLineInterface $line
	 * @return self
	 */
	public function addLine(DeliveryLineInterface $line)
	{
		$line->setDelivery($this);
		$this->lines->add($line);

		return $this;
	}

	/**
	 * Remove lines
	 *
	 * @param BillLineInterface $line
	 */
	public function removeLine(DeliveryLineInterface $line)
	{
		$line->setDelivery();
		$this->lines->removeElement($line);

		return $this;
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
	 * @param SupplierInterface $supplier
	 * @return self
	 */
	public function setSupplier(SupplierInterface $supplier)
	{
		$this->supplier = $supplier;
		
		return $this;
	}
	
	/**
	 * 
	 * @return self
	 */
	public function getSupplier()
	{
		return $this->supplier;
	}
}