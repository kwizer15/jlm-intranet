<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JLM\OfficeBundle\Model\OrderInterface;
use JLM\OfficeBundle\Factory\OrderFactory;
use JLM\CommerceBundle\Builder\VariantOrderBuilder;
use JLM\OfficeBundle\Model\OrderLineInterface;
use JLM\DailyBundle\Model\WorkInterface;

/**
 * JLM\OfficeBundle\Entity\Order
 */
class Order implements OrderInterface
{
	const STATE_INPUT = 0;
	const STATE_ORDERED = 1;
	const STATE_RECEIVED = 2;
	
	/**
	 * @var int $id
	 */
	private $id;
	
	/**
	 * @var DateTime $creation 
	 */
	private $creation;
	
	/**
	 * @var DateTime $close
	 */
	private $close;
	
	/**
	 * Lignes
	 * @var ArrayCollection $lines
	 */
	private $lines;
	
	/**
	 * Intervention source
	 * @var Work
	 */
	private $work;
	
	/**
	 * Temps technicien prévu (en heure)
	 * @var int
	 */
	private $time;
	
	/**
	 * Etat
	 * @var int
	 * 0 - en saisie
	 * 1 - commandé
	 * 2 - reçue
	 */
	private $state = 0;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creation = new \DateTime;
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
     * Add lines
     *
     * @param OrderLineInterface $lines
     * @return self
     */
    public function addLine(OrderLineInterface $line)
    {
        $this->lines->add($line);
    
        return $this;
    }

    /**
     * Remove lines
     *
     * @param OrderLineInterface $lines
     */
    public function removeLine(OrderLineInterface $line)
    {
        $this->lines->removeElement($line);
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
     * Set creation
     *
     * @param \DateTime $creation
     * @return self
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
     * Set time
     * @param unknown $time
     * @return self
     */
    public function setTime($time)
    {
    	$this->time = $time;
    	
    	return $this;
    }
    
    /**
     * Get time
     * @return number
     */
    public function getTime()
    {
    	return $this->time;
    }
    
    /**
     * Set close
     *
     * @param \DateTime $close
     * @return self
     */
    public function setClose(\DateTime $close = null)
    {
    	$this->close = ($close === null) ? new \DateTime : $close;
    
    	return $this;
    }
    
    /**
     * Get close
     *
     * @return \DateTime
     */
    public function getClose()
    {
    	return $this->close;
    }
    
    /**
     * Set state
     *
     * @param int $state
     * @return self
     */
    public function setState($state)
    {
    	if ($state >= 0 && $state < 3)
    	{
    		$this->state = $state;
    	}
    
    	return $this;
    }
    
    /**
     * Get state
     * @return string
     */
    public function getState()
    {
    	return $this->state;
    }

    /**
     * Set work
     *
     * @param Work $work
     * @return self
     */
    public function setWork(WorkInterface $work = null)
    {
        $this->work = $work;
    
        return $this;
    }

    /**
     * Get work
     *
     * @return \JLM\DailyBundle\Entity\Work 
     */
    public function getWork()
    {
        return $this->work;
    }
}