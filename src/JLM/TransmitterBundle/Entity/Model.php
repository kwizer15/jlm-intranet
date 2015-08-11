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

use JLM\ProductBundle\Model\ProductInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Model
{
    /**
     * @var integer $id
     */
    private $id;
    
    /**
     * @var string
     */
    private $text;
    
    /**
     * @var ProductInterface
     */
    private $product;
    
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
     * Set text
     *
     * @param string $text
     * @return self
     */
    public function setText($text)
    {
    	$this->text = $text;
    }
    
    /**
     *
     * @return string
     */
    public function getText()
    {
    	return $this->text;
    }
    
    /**
     *
     * @return string
     */
    public function __toString()
    {
    	return $this->getText();
    }
    
    /**
     * Set product
     *
     * @param ProductInterface $product
     * @return Model
     */
    public function setProduct(ProductInterface $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return ProductInterface 
     */
    public function getProduct()
    {
        return $this->product;
    }
    
}