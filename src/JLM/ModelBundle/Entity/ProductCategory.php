<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\ProductCategory
 *
 * @ORM\Table(name="product_category")
 * @ORM\Entity
 */
class ProductCategory extends StringModel
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
     * @var ProductCategory $parent
     * 
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="children")
     * @Assert\Valid
     */
    private $parent;

    /**
     * @var ProductCategory $children
     *
     * @ORM\OneToMany(targetEntity="ProductCategory", mappedBy="parent")
     * @Assert\Valid(traverse=true)
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
     * Set parent
     *
     * @param JLM\ModelBundle\Entity\ProductCategory $parent
     */
    public function setParent($parent)
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
    public function addProductCategory($children)
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