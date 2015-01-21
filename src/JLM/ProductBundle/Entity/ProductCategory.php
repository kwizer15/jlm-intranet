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

use JLM\ProductBundle\Model\ProductCategoryInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductCategory implements ProductCategoryInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var ProductCategory $parent
     */
    protected $parent;

    /**
     * @var ProductCategory $children
     */
    protected $children;
    
    /**
     * @var string
     */
    protected $name = '';
    
    /**
     * Set text
     *
     * @param string $text
     */
    public function setName($name)
    {
    	$this->name = $name;
    	
    	return $this;
    }
    
    /**
     * Get text
     *
     * @return string
     */
    public function getName()
    {
    	return $this->name;
    }
    
    /**
     * To String
     * @return string
     */
    public function __toString()
    {
    	return $this->getName();
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * {@inheritdoc}
     */
    public function isSmallSupply()
    {
        return $this->getName() == 'Emetteurs';
    }
    
    /**
     * {@inheritdoc}
     */
    public function isService()
    {
        return $this->getName() == 'Service';
    }

    /**
     * Set parent
     *
     * @param ProductCategoryInterface $parent
     */
    public function setParent(ProductCategoryInterface $parent = null)
    {
        $this->parent = $parent;
        
        return $this;
    }

    /**
     * Get parent
     *
     * @return ProductCategoryInterface 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param ProductCategoryInterface $child
     * @return boolean
     * @deprecated
     */
    public function addProductCategory(ProductCategoryInterface $child)
    {
        return $this->addChild($child);
    }
    
    /**
     * Add child
     *
     * @param ProductCategoryInterface $child
     * @return boolean
     */
    public function addChild(ProductCategoryInterface $child)
    {
        return $this->children->add($child);
    }
    
    /**
     * Remove child
     *
     * @param ProductCategoryInterface $child
     * @return boolean
     * @deprecated
     */
    public function removeProductCategory(ProductCategoryInterface $child)
    {
    	return $this->removeChild($child);
    }

    /**
     * Remove child
     *
     * @param ProductCategoryInterface $child
     * @return boolean
     */
    public function removeChild(ProductCategoryInterface $child)
    {
        return $this->children->removeElement($child);
    }
    
    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

}