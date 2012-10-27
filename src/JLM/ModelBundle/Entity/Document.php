<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Document
 *
 * @ORM\MappedSuperclass
 */
abstract class Document
{
	/**
	 * @var datetime $creation
	 *
	 * @ORM\Column(name="creation", type="datetime")
	 */
	private $creation;
	
    /**
     * Client
     * @var Trustee $trustee
     *
     * @ORM\ManyToOne(targetEntity="Trustee")
     */
    private $trustee;

    /**
     * Copie du nom
     * @var string $trusteeName
     *
     * @ORM\Column(name="trustee_name", type="string", length=255)
     */
    private $trusteeName;
    
    /**
     * Copie de l'adresse de facturation
     * @var string $trusteeAddress
     * 
     * @ORM\Column(name="trustee_address", type="text")
     */
    private $trusteeAddress;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->contents = new ArrayCollection;
    }
}