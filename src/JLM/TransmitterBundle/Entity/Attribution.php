<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\OfficeBundle\Entity\Bill;
use JLM\OfficeBundle\Entity\BillLine;
use JLM\ModelBundle\Entity\Product;
/**
 * Attribution
 *
 * @ORM\Table(name="transmitters_attributions")
 * @ORM\Entity(repositoryClass="JLM\TransmitterBundle\Entity\AttributionRepository")
 */
class Attribution
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

    /**
     * populate Bill from Attribution
     * 
     * @return Bill
     */
    public function populateBill(Bill $bill, $vat, $earlyPayment = '', $penalty = '', $property = '', Product $port = null)
    {
    	$bill->populateFromSite($this->getSite(),$this->getAsk()->getTrustee());
    	$transmitters = $this->getTransmitters();
    	$models = array();
    	foreach ($transmitters as $transmitter)
    	{
    		$key = $transmitter->getModel()->getId();
    		if (!isset($models[$key]))
    		{
    			$models[$key]['quantity'] = 0;
    			$models[$key]['product'] = $transmitter->getModel()->getProduct();
    			$models[$key]['numbers'] = array();
    		}
    		$models[$key]['quantity']++;
    		$models[$key]['numbers'][] = $transmitter->getNumber();
    	}
    	
    	$position = 0;
    	foreach ($models as $key=>$values)
    	{
    		asort($values['numbers']);
    		 
    		$description = '';
    		$n1 = $temp = $values['numbers'][0];
    		$i = 1;
    		$size = sizeof($values['numbers']);
    		if ($size > 1)
    		{
	    		do {
	    			if ($values['numbers'][$i] != $temp + 1)
	    			{
	    				$n2 = $temp;
	    				if ($n1 == $n2)
	    					$description .= 'n°'.$n1;
	    				else
	    					$description .= 'du n°'.$n1.' au n°'.$n2;
	    				$description .= chr(10);
	    				$n1 = $models[$key]['numbers'][$i];
	    			}
	    			$temp = $values['numbers'][$i];
	    			$i++;
	    		} while ($i < $size);
	    		$description .= 'du n°'.$n1.' au n°'.$temp;
    		}
    		else 
    			$description .= 'n°'.$n1;
    		
    		$line = new BillLine;
    		$line->setPosition($position);
    		$line->setDesignation($values['product']->getDesignation());
    		$line->setIsTransmitter(true);
    		$line->setProduct($values['product']);
    		$line->setQuantity($values['quantity']);
    		$line->setReference($values['product']->getReference());
    		$line->setShowDescription(true);
    		$line->setDescription($description);
    		$line->setUnitPrice($values['product']->getUnitPrice($values['quantity'])); // Ajouter prix unitaire quantitatif
    		$line->setVat($vat);
    		$line->setBill($bill);
    		$bill->addLine($line);
    		$position++;
    	}
    	if ($port !== null)
    	{
    		$line = new BillLine;
    		$line->setPosition($position);
    		$line->setDesignation($port->getDesignation());
    		$line->setIsTransmitter(true);
    		$line->setProduct($port);
    		$line->setQuantity(1);
    		$line->setReference($port->getReference());
    		$line->setUnitPrice($port->getUnitPrice(sizeof($transmitters)));
    		$line->setVat($vat);
    		$line->setBill($bill);
    		$bill->addLine($line);
    		$position++;
    	}
    	$bill->setCreation(new \DateTime);
    	$bill->setReference('Selon OS');
    	$bill->setVatTransmitter($vat);
    	$bill->setMaturity(30);
    	$bill->setEarlyPayment($earlyPayment);
    	$bill->setPenalty($penalty);
    	$bill->setProperty($property);
    	return $bill;
    }
}