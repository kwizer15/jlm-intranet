<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity
 */
class Product
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
     * @var string $designation
     *
     * @ORM\Column(name="designation", type="string", length=255)
     */
    private $designation;

    /**
     * @var text $description
     * 
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @var Supplier $supplier
     * 
     * @ORM\ManyToOne(targetEntity="Supplier")
     */
    private $supplier;
    
    /**
     * @var string $reference
     *
     * @ORM\Column(name="reference", type="string", length=16)
     */
    private $reference;

    /**
     * @var string $barcode
     *
     * @ORM\Column(name="barcode", type="string", length=255)
     */
    private $barcode;

    /**
     * @var decimal $margin
     *
     * @ORM\Column(name="margin", type="decimal")
     */
    private $margin;

    /**
     * @var integer $vat
     *
     * @ORM\Column(name="vat", type="integer")
     */
    private $vat;

    /**
     * @var LinkedFile $files
     * 
     * @ORM\OneToMany(targetEntity="LinkedFile", mappedBy="product")
     */
    private $files;

    /**
     * Pour les kits
     * @var Product[] $children
     * 
     * @ORM\OneToMany(targetEntity="Product", mappedBy="parent")
     */
    private $children;
    
    /**
     * Pour les kits
     * @var Product $parent
     * 
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="children")
     */
    private $parent;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->files = new ArrayCollection;
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
     * Set designation
     *
     * @param string $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
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
     * Set reference
     *
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
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
     * Set barcode
     *
     * @param string $barcode
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
    }

    /**
     * Get barcode
     *
     * @return string 
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set margin
     *
     * @param decimal $margin
     */
    public function setMargin($margin)
    {
        $this->margin = $margin;
    }

    /**
     * Get margin
     *
     * @return decimal 
     */
    public function getMargin()
    {
        return $this->margin;
    }

    /**
     * Set vat
     *
     * @param integer $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * Get vat
     *
     * @return integer 
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set supplier
     *
     * @param JLM\ModelBundle\Entity\Supplier $supplier
     */
    public function setSupplier(\JLM\ModelBundle\Entity\Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * Get supplier
     *
     * @return JLM\ModelBundle\Entity\Supplier 
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Add files
     *
     * @param JLM\ModelBundle\Entity\LinkedFile $files
     */
    public function addLinkedFile(\JLM\ModelBundle\Entity\LinkedFile $files)
    {
        $this->files[] = $files;
    }

    /**
     * Get files
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Add children
     *
     * @param JLM\ModelBundle\Entity\Product $children
     */
    public function addProduct(\JLM\ModelBundle\Entity\Product $children)
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

    /**
     * Set parent
     *
     * @param JLM\ModelBundle\Entity\Product $parent
     */
    public function setParent(\JLM\ModelBundle\Entity\Product $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return JLM\ModelBundle\Entity\Product 
     */
    public function getParent()
    {
        return $this->parent;
    }
}