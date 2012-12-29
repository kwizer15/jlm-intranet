<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\OfficeBundle\Entity\Bill
 *
 * @ORM\Table(name="bill")
 * @ORM\Entity
 */
class Bill extends Document
{
	/**
	 * @var int $id
	 * 
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * Numéro du devis
	 * @ORM\Column(name="number", type="integer")
	 */
	private $number;
	
	/**
	 * Porte concernée (pour le suivi)
	 * @var Door $door
	 *
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
	 */
	private $door;
	
	/**
	 * Porte concernée (pour le devis)
	 * @var string $doorCp
	 *
	 * @ORM\Column(name="door_cp",type="text")
	 */
	private $doorCp;
	
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
	 * Set number
	 *
	 * @param string $number
	 * @return Quote
	 */
	public function setNumber($number)
	{
		$this->number = $number;
		return $this;
	}
	
	/**
	 * Get number
	 *
	 * @return string
	 */
	public function getNumber()
	{
		return $this->number;
	}
	
	/**
	 * Set door
	 *
	 * @param JLM\ModelBundle\Entity\Door $door
	 * @return Quote
	 */
	public function setDoor(\JLM\ModelBundle\Entity\Door $door = null)
	{
		$this->door = $door;
	
		return $this;
	}
	
	/**
	 * Get door
	 *
	 * @return JLM\ModelBundle\Entity\Door
	 */
	public function getDoor()
	{
		return $this->door;
	}	
	
	/**
	 * Set doorCp
	 *
	 * @param string $doorCp
	 * @return Quote
	 */
	public function setDoorCp($doorCp)
	{
		$this->doorCp = $doorCp;
	
		return $this;
	}
	
	/**
	 * Get doorCp
	 *
	 * @return string
	 */
	public function getDoorCp()
	{
		return $this->doorCp;
	}
}