<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Entity;

use JLM\CommerceBundle\Model\BillInterface;
use JLM\CommerceBundle\Model\BillLineInterface;
use JLM\ProductBundle\Model\ProductInterface;
use JLM\TransmitterBundle\Model\AttributionInterface;
use JLM\TransmitterBundle\Model\TransmitterInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Attribution implements AttributionInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $creation;

    /**
     * @var string
     */
    private $contact;

    /**
     * @var boolean
     */
    private $individual;

	/**
	 * @var ArrayCollection
	 */
    private $transmitters;
    
    /**
     * @var AskTransmitter
     */
    private $ask;
    
    /**
     * @var Bill
     */
    private $bill;
    
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
     * Set creation
     *
     * @param \DateTime $creation
     * @return Attribution
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
     * Set contact
     *
     * @param string $contact
     * @return Attribution
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set individual
     *
     * @param boolean $individual
     * @return Attribution
     */
    public function setIndividual($individual)
    {
        $this->individual = $individual;
    
        return $this;
    }

    /**
     * Get individual
     *
     * @return boolean 
     */
    public function getIndividual()
    {
        return $this->individual;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->transmitters = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add transmitters
     *
     * @param \JLM\TransmitterBundle\Entity\Transmitter $transmitters
     * @return Attribution
     */
    public function addTransmitter(TransmitterInterface $transmitters)
    {
        $this->transmitters[] = $transmitters;
    
        return $this;
    }

    /**
     * Remove transmitters
     *
     * @param TransmitterInterface $transmitters
     */
    public function removeTransmitter(TransmitterInterface $transmitters)
    {
        $this->transmitters->removeElement($transmitters);
    }

    /**
     * Get transmitters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransmitters()
    {
        return $this->transmitters;
    }

    /**
     * Set ask
     *
     * @param Ask $ask
     * @return TransmitterAttribution
     */
    public function setAsk(Ask $ask = null)
    {
        $this->ask = $ask;
    
        return $this;
    }

    /**
     * Get ask
     *
     * @return Ask
     */
    public function getAsk()
    {
        return $this->ask;
    }

    /**
     * Set bill
     *
     * @param BillInterface $bill
     * @return Attribution
     */
    public function setBill(BillInterface $bill = null)
    {
        $this->bill = $bill;
    
        return $this;
    }

    /**
     * Get bill
     *
     * @return BillInterface 
     */
    public function getBill()
    {
        return $this->bill;
    }
    
    /**
     * Get Site
     * 
     * @return \JLM\ModelBundel\Entity\Site 
     */
    public function getSite()
    {
    	return $this->getAsk()->getSite();
    }
}