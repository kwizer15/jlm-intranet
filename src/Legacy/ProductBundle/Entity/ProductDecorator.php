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

use JLM\ProductBundle\Model\ProductInterface;
use JLM\ProductBundle\Model\ProductCategoryInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class ProductDecorator implements ProductInterface
{
    /**
     * Id
     * @var integer $id
     */
    private $id;

    /**
     * Product
     * @var ProductInterface $product
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
     * {@inheritdoc}
     */
    public function isSmallSupply()
    {
        return $this->getProduct()->isSmallSupply();
    }
    
    /**
     * {@inheritdoc}
     */
    public function isService()
    {
        return $this->getProduct()->isService();
    }
    
    /**
     * Set designation
     *
     * @param string $designation
     * @return self
     */
    public function setDesignation($designation)
    {
        return $this->getProduct()->setDesignation($designation);
    }

    /**
     * {@inheritdoc}
     */
    public function getDesignation()
    {
        return $this->getProduct()->getDesignation();
    }

    /**
     * Set description
     *
     * @param text $description
     * 
     * @return self
     */
    public function setDescription($description)
    {
        return $this->getProduct()->setDescription($description);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
    	return $this->getProduct()->getDescription();
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return self
     */
    public function setReference($reference)
    {
    	return $this->getProduct()->setReference();
    }

    /**
     * {@inheritdoc}
     */
    public function getReference()
    {
    	return $this->getProduct()->getReference();
    }

    /**
     * Set barcode
     *
     * @param string $barcode
     * @return self
     */
    public function setBarcode($barcode)
    {
    	return $this->getProduct()->setBarcode($barcode);
    }

    /**
     * Get barcode
     *
     * @return string 
     */
    public function getBarcode()
    {
    	return $this->getProduct()->getBarcode();
    }
    
    /**
     * Set category
     *
     * @param ProductCategoryInterface $category
     */
    public function setCategory(ProductCategoryInterface $category)
    {
    	return $this->getProduct()->setCategory($category);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory()
    {
    	return $this->getProduct()->getCategory();
    }
    
    /**
     * To String
     * @return string
     */
    public function __toString()
    {
    	return $this->getProduct()->__toString();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUnitPrice($quantity = null)
    {
    	return $this->getProduct()->getUnitPrice($quantity);
    }
}