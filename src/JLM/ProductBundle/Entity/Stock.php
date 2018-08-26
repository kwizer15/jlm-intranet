<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\StockInterface;
use JLM\ProductBundle\Model\ProductInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Stock implements StockInterface
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var ProductInterface
     */
    private $product;
    
    /**
     * @var \DateTime
     */
    private $lastModified;
    
    /**
     * @var float
     */
    private $quantity = 0;
    
    /**
     * @var float
     */
    private $minimum = 0;
    
    /**
     * @var float
     */
    private $maximum = 0;
    
    /**
     * Constructor
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product = null)
    {
        $this->setProduct($product);
    }
    
    /**
     *
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     *
     * @param ProductInterface $product
     * @return self
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
        
        return $this;
    }
    
    /**
     *
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }
    
    /**
     * @return string
     */
    public function getProductName()
    {
        return $this->getProduct()->getDesignation();
    }
    
    /**
     * @return string
     */
    public function getProductReference()
    {
        return $this->getProduct()->getReference();
    }
    
    /**
     *
     * @return DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }
    
    /**
     * Update de lastModified date on persist
     * @return self
     */
    public function updateLastModified()
    {
        $this->lastModified = new \DateTime;
        
        return $this;
    }
    
    /**
     *
     * @param unknown $quantity
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        
        return $this;
    }
    
    /**
     *
     * @return number
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     *
     * @param number $minimum
     * @return self
     */
    public function setMinimum($quantity)
    {
        $this->minimum = $quantity;
    
        return $this;
    }
    
    /**
     *
     * @return number
     */
    public function getMinimum()
    {
        return $this->minimum;
    }
    
    /**
     *
     * @param number $minimum
     * @return self
     */
    public function setMaximum($quantity)
    {
        $this->maximum = $quantity;
    
        return $this;
    }
    
    /**
     *
     * @return number
     */
    public function getMaximum()
    {
        return $this->maximum;
    }
    
    /**
     *
     * @return boolean
     */
    public function isOutOfStock()
    {
        return $this->quantity <= 0;
    }
    
    /**
     * @return boolean
     */
    public function isUnderMinimum()
    {
        return $this->quantity < $this->minimum;
    }
    
    /**
     * @return boolean
     */
    public function getQuantityToOrder()
    {
        $toOrder = $this->maximum - $this->quantity;

        return ($toOrder > 0) ? $toOrder : 0;
    }
    
    /**
     * @return boolean
     */
    public function isMinUnderMax()
    {
        return $this->minimum <= $this->maximum;
    }
}
