<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\OfficeBundle\Entity\Document
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
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
	 * @var datetime $creation
	 *
	 * @ORM\Column(name="lastModified", type="datetime")
	 */
	private $lastModified;
	
    /**
     * Client
     * @var JLM\ModelBundle\Entity\Trustee $trustee
     *
     * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Trustee")
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
     * @var float $vat
     *
     * @ORM\Column(name="vat",type="decimal",precision=3,scale=3)
     */
    private $vat;
    
    /**
     * @var float $vatTransmitter
     *
     * @ORM\Column(name="vat_transmitter",type="decimal",precision=3,scale=3)
     */
    private $vatTransmitter;
    
    /**
     * Set creation
     *
     * @param \DateTime $creation
     * @return Document
     */
    public function setCreation($creation)
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
     * Get last modified
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set trusteeName
     *
     * @param string $trusteeName
     * @return Document
     */
    public function setTrusteeName($trusteeName)
    {
        $this->trusteeName = $trusteeName;
    
        return $this;
    }

    /**
     * Get trusteeName
     *
     * @return string 
     */
    public function getTrusteeName()
    {
        return $this->trusteeName;
    }

    /**
     * Set trusteeAddress
     *
     * @param string $trusteeAddress
     * @return Document
     */
    public function setTrusteeAddress($trusteeAddress)
    {
        $this->trusteeAddress = $trusteeAddress;
    
        return $this;
    }

    /**
     * Get trusteeAddress
     *
     * @return string 
     */
    public function getTrusteeAddress()
    {
        return $this->trusteeAddress;
    }

    /**
     * Set trustee
     *
     * @param JLM\ModelBundle\Entity\Trustee $trustee
     * @return Document
     */
    public function setTrustee(\JLM\ModelBundle\Entity\Trustee $trustee = null)
    {
        $this->trustee = $trustee;
    
        return $this;
    }

    /**
     * Get trustee
     *
     * @return JLM\ModelBundle\Entity\Trustee 
     */
    public function getTrustee()
    {
        return $this->trustee;
    }
    
    
    /**
     * Set vat
     *
     * @param float $vat
     * @return Quote
     */
    public function setVat($vat)
    {
    	$this->vat = $vat;
    
    	return $this;
    }
    
    /**
     * Get vat
     *
     * @return float
     */
    public function getVat()
    {
    	return $this->vat;
    }
    
    /**
     * Set vatTransmitter
     *
     * @param float $vatTransmitter
     * @return Quote
     */
    public function setVatTransmitter($vat)
    {
    	$this->vatTransmitter = $vat;
    
    	return $this;
    }
    
    /**
     * Get vatTransmitter
     *
     * @return float
     */
    public function getVatTransmitter()
    {
    	return $this->vatTransmitter;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function update()
    {
        $this->lastModified = new \DateTime;
    }
}