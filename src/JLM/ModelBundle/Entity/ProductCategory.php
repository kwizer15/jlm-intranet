<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\ProductCategory
 *
 * @ORM\Table(name="product_category")
 * @ORM\Entity
 */
class ProductCategory
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ProductCategory $parent
     * 
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="children")
     */
    private $parent;

    /**
     * @var ProductCategory $children
     *
     * @ORM\OneToMany(targetEntity="ProductCategory", mappedBy="parent")
     */
    private $children;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->children = new ArrayCollection;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set parent
     *
     * @param JLM\ModelBundle\Entity\ProductCategory $parent
     */
    public function setParent(\JLM\ModelBundle\Entity\ProductCategory $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return JLM\ModelBundle\Entity\ProductCategory 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param JLM\ModelBundle\Entity\ProductCategory $children
     */
    public function addProductCategory(\JLM\ModelBundle\Entity\ProductCategory $children)
    {
        $this->children[] = $children;
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