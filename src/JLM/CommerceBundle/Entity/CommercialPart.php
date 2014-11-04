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

use JLM\CommerceBundle\Model\CommercialPartInterface;
use JLM\ModelBundle\Entity\Trustee as CustomerInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class CommercialPart implements CommercialPartInterface
{
	/**
	 * @var datetime $creation
	 */
	private $creation;
	
    /**
     * Client
     * @var CustomerInterface $trustee
     */
    private $trustee;

    /**
     * Copie du nom
     * @var string $trusteeName
     */
    private $trusteeName;
    
    /**
     * Copie de l'adresse de facturation
     * @var string $trusteeAddress
     */
    private $trusteeAddress;

    
    /**
     * @var float $vat
     */
    private $vat;
    
    /**
     * @var float $vatTransmitter
     */
    private $vatTransmitter;
    
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
     * Set trusteeName
     *
     * @param string $trusteeName
     * @return self
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
     * @return self
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
     * @param CustomerInterface $trustee
     * @return self
     */
    public function setTrustee(CustomerInterface $trustee = null)
    {
        $this->trustee = $trustee;
    
        return $this;
    }

    /**
     * Get trustee
     *
     * @return CustomerInterface 
     */
    public function getTrustee()
    {
        return $this->trustee;
    }
    
    
    /**
     * Set vat
     *
     * @param float $vat
     * @return self
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
     * @return self
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
}