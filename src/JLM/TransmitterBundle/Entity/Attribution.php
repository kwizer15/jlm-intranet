<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\OfficeBundle\Entity\Bill;
use JLM\OfficeBundle\Entity\BillLine;
use JLM\ProductBundle\Model\ProductInterface;
use JLM\TransmitterBundle\Model\AttributionInterface;
/**
 * Attribution
 *
 * @ORM\Table(name="transmitters_attributions")
 * @ORM\Entity(repositoryClass="JLM\TransmitterBundle\Entity\AttributionRepository")
 */
class Attribution implements AttributionInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation", type="date")
     */
    private $creation;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact;

    /**
     * @var boolean
     *
     * @ORM\Column(name="individual", type="boolean")
     */
    private $individual;

	/**
	 * @var ArrayCollection
	 * 
	 * @ORM\OneToMany(targetEntity="Transmitter", mappedBy="attribution")
	 * @ORM\OrderBy({"number" = "ASC"})
	 */
    private $transmitters;
    
    /**
     * @var AskTransmitter
     *
     * @ORM\ManyToOne(targetEntity="Ask", inversedBy="attributions")
     */
    private $ask;
    
    /**
     * @var Bill
     *
     * @ORM\ManyToOne(targetEntity="\JLM\OfficeBundle\Entity\Bill")
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
    public function addTransmitter(\JLM\TransmitterBundle\Entity\Transmitter $transmitters)
    {
        $this->transmitters[] = $transmitters;
    
        return $this;
    }

    /**
     * Remove transmitters
     *
     * @param \JLM\TransmitterBundle\Entity\Transmitter $transmitters
     */
    public function removeTransmitter(\JLM\TransmitterBundle\Entity\Transmitter $transmitters)
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
     * @param \JLM\OTransmitterBundle\Entity\Ask $ask
     * @return TransmitterAttribution
     */
    public function setAsk(\JLM\TransmitterBundle\Entity\Ask $ask = null)
    {
        $this->ask = $ask;
    
        return $this;
    }

    /**
     * Get ask
     *
     * @return \JLM\OfficeBundle\Entity\Ask
     */
    public function getAsk()
    {
        return $this->ask;
    }

    /**
     * Set bill
     *
     * @param \JLM\OfficeBundle\Entity\Bill $bill
     * @return Attribution
     */
    public function setBill(\JLM\OfficeBundle\Entity\Bill $bill = null)
    {
        $this->bill = $bill;
    
        return $this;
    }

    /**
     * Get bill
     *
     * @return \JLM\OfficeBundle\Entity\Bill 
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