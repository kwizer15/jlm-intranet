<?php

namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductCategoryInterface;

/**
 * JLM\ModelBundle\Entity\ProductCategory
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
        return $this->getId() === 1;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isService()
    {
        return $this->getId() === 2;
    }

    /**
     * Set parent
     *
     * @param ProductCategoryInterface $parent
     */
    public function setParent(ProductCategoryInterface $parent = null)
    {
        $this->parent = $parent;
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
     * Add children
     *
     * @param ProductCategoryInterface $children
     * @return boolean
     */
    public function addProductCategory(ProductCategoryInterface $children)
    {
        return $this->children->add($children);
    }
    
    /**
     * Remove children
     *
     * @param ProductCategoryInterface $children
     * @return boolean
     */
    public function removeProductCategory(ProductCategoryInterface $children)
    {
    	return $this->children->removeElement($children);
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