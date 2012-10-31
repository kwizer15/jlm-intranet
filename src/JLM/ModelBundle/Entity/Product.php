<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\ProductRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * 		"product" = "Product",
 * 		"transmitter" = "Transmitter"
 * })
 */
class Product
{
    /**
     * Id
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Designation
     * @var string $designation
     *
     * @ORM\Column(name="designation", type="string", length=255)
     */
    private $designation;

    /**
     * Description longue
     * @var text $description
     * 
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * Fournisseur principal
     * @var Supplier $supplier
     * 
     * @ORM\ManyToOne(targetEntity="Supplier")
     */
    private $supplier;
    
    /**
     * Reference produit
     * @var string $reference
     *
     * @ORM\Column(name="reference", type="string", length=16)
     */
    private $reference;

    /**
     * Code barre
     * @var string $barcode
     *
     * @ORM\Column(name="barcode", type="string", length=255, nullable=true)
     */
    private $barcode;

    /**
     * Marge (en %)
     * @var decimal $margin
     * 
     * @ORM\Column(name="margin", type="smallint")
     */
    private $margin;

    /**
     * Taux de TVA (en %)
     * @var integer $vat
     * 
     * @ORM\ManyToOne(targetEntity="VAT")
     */
    private $vat;

    /**
     * Famille de produit
     * @var ProductCategory $category
     * 
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     */
    private $category;
    
    /**
     * Prix d'achat HT
     * @var float $purchase
     * 
     * @ORM\Column(name="purchase",type="decimal", scale=2)
     */
    private $purchase;
    
    /**
     * Taux de remise fournisseur (en %)
     * @var float $discountSupplier
     * 
     * @ORM\Column(name="discount_supplier", type="smallint")
     */
    private $discountSupplier;
    
    /**
     * Taux de frais (en %)
     * @var float $expenseRatio
     * 
     * @ORM\Column(name="expense_ratio", type="smallint")
     */
    private $expenseRatio;
    
    /**
     * Frais de port (en €)
     * @var float $shipping
     * 
     * @ORM\Column(name="shipping", type="decimal", scale=2)
     */
    private $shipping;
    
    /**
     * Unité (pièce, mètre...)
     * @var string $unity
     * 
     * @ORM\Column(name="unity",type="string",length=255)
     */
    private $unity;
    
    /**
     * Fichiers liés (plans, docs...)
     * @var LinkedFile[] $files
     * 
     * ORM\OneToMany(targetEntity="LinkedFile", mappedBy="product")
     */
    // private $files;

    /**
     * Photo
     * @var LinkedFile $picture
     *
     *
     */
    // private $picture;
    
    /**
     * Pour les kits
     * @var Product[] $children
     * 
     * ORM\OneToMany(targetEntity="Product", mappedBy="parent")
     */
    // private $children;
    
    /**
     * Pour les kits
     * @var Product $parent
     * 
     * ORM\ManyToOne(targetEntity="Product", inversedBy="children")
     */
    // private $parent;
    
    /**
     * Constructor
     */
//    public function __construct()
//    {
//    	$this->files = new ArrayCollection;
//    	$this->children = new ArrayCollection;
//    }
    

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
     * Set purchase
     *
     * @param decimal $purchase
     */
    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Get purchase
     *
     * @return decimal 
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

    /**
     * Set discountSupplier
     *
     * @param decimal $discountSupplier
     */
    public function setDiscountSupplier($discountSupplier)
    {
        $this->discountSupplier = $discountSupplier;
    }

    /**
     * Get discountSupplier
     *
     * @return decimal 
     */
    public function getDiscountSupplier()
    {
        return $this->discountSupplier;
    }

    /**
     * Set expenseRatio
     *
     * @param decimal $expenseRatio
     */
    public function setExpenseRatio($expenseRatio)
    {
        $this->expenseRatio = $expenseRatio;
    }

    /**
     * Get expenseRatio
     *
     * @return decimal 
     */
    public function getExpenseRatio()
    {
        return $this->expenseRatio;
    }

    /**
     * Set shipping
     *
     * @param decimal $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * Get shipping
     *
     * @return decimal 
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set unity
     *
     * @param string $unity
     */
    public function setUnity($unity)
    {
        $this->unity = $unity;
    }

    /**
     * Get unity
     *
     * @return string 
     */
    public function getUnity()
    {
        return $this->unity;
    }

    /**
     * Set vat
     *
     * @param JLM\ModelBundle\Entity\VAT $vat
     */
    public function setVat(\JLM\ModelBundle\Entity\VAT $vat)
    {
        $this->vat = $vat;
    }

    /**
     * Get vat
     *
     * @return JLM\ModelBundle\Entity\VAT 
     */
    public function getVat()
    {
        return $this->vat;
    }
    
    public function getPurchasePrice()
    {
    	$pa = $this->getPurchase();
    	$remise_fournisseur = $pa * ($this->getDiscountSupplier()/100);
    	$pa -= $remise_fournisseur;
    	$frais = $pa * ($this->getExpenseRatio()/100);
    	$pa += $frais;
    	$pa += $this->getShipping();
    	return $pa;
    }
    
    public function getSellPrice()
    {
    	return ($this->getPurchasePrice() + $this->getMarginValue());
    }
    
    public function getMarginValue()
    {
    	return $this->getPurchasePrice() * ($this->getMargin()/100);
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
     * Set category
     *
     * @param JLM\ModelBundle\Entity\ProductCategory $category
     */
    public function setCategory(\JLM\ModelBundle\Entity\ProductCategory $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return JLM\ModelBundle\Entity\ProductCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->getSupplier().' '.$this->getDesignation();
    }
}