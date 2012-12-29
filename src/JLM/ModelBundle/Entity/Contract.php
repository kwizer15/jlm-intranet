<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Contract
 *
 * @ORM\Table(name="contracts")
 * @ORM\Entity
 */
class Contract
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $number
     *
     * @ORM\Column(name="number", type="string", length=32)
     */
    private $number;

    /**
     * @var Trustee $trustee
     * 
     * @ORM\ManyToOne(targetEntity="Trustee")
     */
    private $trustee;
    
    /**
     * Contrat complet
     * @var bool $complete
     * 
     * @ORM\Column(name="complete", type="smallint")
     */
    private $complete;
    
    /**
     * Contract C1 C2...
     * @var smallint $option
     *
     * @ORM\Column(name="contract_option", type="smallint")
     */
    private $option;
    
    /**
     * @var Door $door
     * 
     * @ORM\ManyToOne(targetEntity="Door", inversedBy="contracts")
     */
    private $door;
    
    /**
     * @var datetime $begin
     *
     * @ORM\Column(name="begin", type="datetime")
     */
    private $begin;

    /**
     * @var datetime $endWarranty
     *
     * @ORM\Column(name="end_warranty", type="datetime", nullable=true)
     */
    private $endWarranty;

    /**
     * @var datetime $end
     *
     * @ORM\Column(name="end_contract", type="datetime", nullable=true)
     */
    private $end;

    /**
     * @var decimal $fee
     *
     * @ORM\Column(name="fee", type="decimal", scale=2)
     */
    private $fee;
    
    /**
     * To String
     */
    public function __toString()
    {
    	return ($this->isComplete() ? 'C'.($this->getOption()+1) : 'N'.($this->getOption()+3));
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
     * Set number
     *
     * @param string $number
     * @return Contract
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
     * Set complete
     *
     * @param boolean $complete
     * @return Contract
     */
    public function setComplete($complete = true)
    {
        $this->complete = $complete;
    
        return $this;
    }

    /**
     * Get complete
     *
     * @return boolean 
     */
    public function getComplete()
    {
        return $this->complete;
    }
    
    /**
     * Is complete
     *
     * @return boolean
     */
    public function isComplete()
    {
    	return $this->getComplete();
    }

    /**
     * Set normal
     *
     * @param boolean $normal
     * @return Contract
     */
    public function setNormal($normal = true)
    {
    	$this->complete = !$normal;
    
    	return $this;
    }
    
    /**
     * Get normal
     *
     * @return boolean
     */
    public function getNormal()
    {
    	return !$this->getComplete();
    }
    
    /**
     * Is normal
     *
     * @return boolean
     */
    public function isNormal()
    {
    	return $this->getNormal();
    }
    
    /**
     * Set option
     *
     * @param integer $option
     * @return Contract
     */
    public function setOption($option)
    {
        $this->option = $option;
    
        return $this;
    }

    /**
     * Get option
     *
     * @return integer 
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Set begin
     *
     * @param \DateTime $begin
     * @return Contract
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;
    
        return $this;
    }

    /**
     * Get begin
     *
     * @return \DateTime 
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Set endWarranty
     *
     * @param \DateTime $endWarranty
     * @return Contract
     */
    public function setEndWarranty($endWarranty)
    {
        $this->endWarranty = $endWarranty;
    
        return $this;
    }

    /**
     * Get endWarranty
     *
     * @return \DateTime 
     */
    public function getEndWarranty()
    {
        return $this->endWarranty;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Contract
     */
    public function setEnd($end)
    {
        $this->end = $end;
    
        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set fee
     *
     * @param float $fee
     * @return Contract
     */
    public function setFee($fee)
    {
        $this->fee = $fee;
    
        return $this;
    }

    /**
     * Get fee
     *
     * @return float 
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Set door
     *
     * @param JLM\ModelBundle\Entity\Door $door
     * @return Contract
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
     * Set trustee
     *
     * @param JLM\ModelBundle\Entity\Trustee $trustee
     * @return Contract
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
}