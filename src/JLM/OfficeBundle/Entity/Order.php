<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\DailyBundle\Entity\Work;

/**
 * JLM\OfficeBundle\Entity\Order
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="JLM\OfficeBundle\Entity\OrderRepository")
 */
class Order
{
	const STATE_INPUT = 0;
	const STATE_ORDERED = 1;
	const STATE_RECEIVED = 2;
	
	/**
	 * @var int $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @var DateTime $creation
	 * @ORM\Column(name="creation",type="datetime") 
	 */
	private $creation;
	
	/**
	 * Lignes
	 * @var ArrayCollection $lines
	 * @ORM\OneToMany(targetEntity="OrderLine", mappedBy="order")
	 */
	private $lines;
	
	/**
	 * Intervention source
	 * @var Work
	 * @ORM\OneToOne(targetEntity="JLM\DailyBundle\Entity\Work",inversedBy="order")
	 */
	private $work;
	
	/**
	 * Etat
	 * @var int
	 * 0 - en saisie
	 * 1 - commandé
	 * 2 - reçue
	 * @ORM\Column(name="state",type="integer")
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
     * @param JLM\OfficeBundle\Entity\OrderLine $lines
     * @return Order
     */
    public function addLine(\JLM\OfficeBundle\Entity\OrderLine $lines)
    {
        $this->lines[] = $lines;
    
        return $this;
    }

    /**
     * Remove lines
     *
     * @param JLM\OfficeBundle\Entity\OrderLine $lines
     */
    public function removeLine(\JLM\OfficeBundle\Entity\OrderLine $lines)
    {
        $this->lines->removeElement($lines);
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
     * Set state
     *
     * @param int $state
     * @return Order
     */
    public function setState($state)
    {
    	if ($state >= 0 && $state < 3)
    	$this->state = $state;
    
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
     * @param \JLM\DailyBundle\Entity\Work $work
     * @return Order
     */
    public function setWork(\JLM\DailyBundle\Entity\Work $work = null)
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
    
    /**
     * Create from QuoteVariant
     */
    public static function createFromWork(Work $work)
    {
    	$order = new Order;
    	$order->setCreation(new \DateTime);
    	$order->setWork($work);
    	if ($variant = $work->getQuote())
    	{
    		$vlines = $variant->getLines();
    		foreach ($vlines as $vline)
    		{
    			$flag = true;
    			if ($product = $vline->getProduct())
    			if ($category = $product->getCategory())
    			if ($category->getId() == 2)
    				$flag = false;
    			if ($flag)
    			{
    				$oline = new OrderLine;
    				$oline->setReference($vline->getReference());
    				$oline->setQuantity($vline->getQuantity());
    				$oline->setDesignation($vline->getDesignation());
    				$entity->addLine($oline);
    			}
    		}
    	}
    	return $order;
    }
}