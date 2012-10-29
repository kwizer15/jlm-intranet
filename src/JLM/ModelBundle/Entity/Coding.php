<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Chiffrage
 * (base de devis)
 * JLM\ModelBundle\Entity\Coding
 *
 * @ORM\Table(name="coding")
 * @ORM\Entity
 */
class Coding extends Document
{
	/**
	 * Numéro du devis
	 * @var int $id
	 * 
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * Contenus
	 * @var ArrayCollection
	 * 
	 * @ORM\OneToMany(targetEntity="CodingLine",mappedBy="coding")
	 */
	private $lines;
	
	/**
	 * Porte
	 * @var Door $doors
	 *
	 * @ORM\ManyToMany(targetEntity="Door",inversedBy="codings")
	 */
	private $doors;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->contents = new ArrayCollection;
		$this->doors = new ArrayCollection;
	}
}