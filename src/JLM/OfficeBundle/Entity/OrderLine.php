<?php
namespace JLM\OfficeBundle\Entity;

/**
 * JLM\OfficeBundle\Entity\DocumentLine
 */
class OrderLine
{
	/**
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * Commande a laquelle appartien la ligne
	 * @var Order $order
	 */
	private $order;
	
	/**
	 * Position de la ligne dans le devis
	 * @var position
	 */
	private $position = 0;
	
	/**
	 * @var string $reference
	 */
	private $reference;
	
	/**
	 * @var string $designation
	 */
	private $designation;
	
	/**
	 * @var int $quantity
	 */
	private $quantity = 1;

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
     * Set order
     *
     * @param Order $order
     * @return OrderLine
     */
    public function setOrder(Order $order)
    {
    	$this->order = $order;
    	
    	return $this;
    }
    
    /**
     * Get order
     *
     * @return Order
     */
    public function getOrder()
    {
    	return $this->order;
    }
    
    /**
     * Set position
     *
     * @param integer $position
     * @return OrderLine
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return OrderLine
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    
        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set designation
     *
     * @param string $designation
     * @return OrderLine
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    
        return $this;
    }

    /**
     * Get designation
     *
     * @return string 
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return OrderLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}