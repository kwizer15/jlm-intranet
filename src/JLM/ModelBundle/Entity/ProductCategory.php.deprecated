<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\ProductBundle\Model\ProductCategoryInterface;

/**
 * JLM\ModelBundle\Entity\ProductCategory
 *
 * @ORM\Table(name="product_category")
 * @ORM\Entity
 */
class ProductCategory extends StringModel implements ProductCategoryInterface
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
     */
    public function addProductCategory(ProductCategoryInterface $children)
    {
        $this->children->add($children);
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