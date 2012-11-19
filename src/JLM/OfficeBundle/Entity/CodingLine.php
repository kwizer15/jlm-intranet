<?php
namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\OfficeBundle\Entity\CodingLine
 *
 * @ORM\Table(name="coding_lines")
 * @ORM\Entity
 */
class CodingLine
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
	 * @var Coding $coding
	 * 
	 * @ORM\ManyToOne(targetEntity="Coding",inversedBy="lines")
	 */
	private $coding;
	
	/**
	 * Position de la ligne dans le devis
	 * @var position
	 * 
	 * @ORM\Column(name="position", type="smallint", nullable=true)
	 */
	private $position = 0;
	
	/**
	 * @var JLM\ModelBundle\Entity\Product
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Product")
	 */
	private $product;
	
	/**
	 * @var string $reference
	 * 
	 * @ORM\Column(name="reference", nullable=true)
	 */
	private $reference;
	
	/**
	 * @var string $designation
	 *
	 * @ORM\Column(name="designation")
	 */
	private $designation;
	
	/**
	 * @var bool $isTransmitter
	 *
	 * @ORM\Column(name="is_transmitter", type="boolean", nullable=true)
	 */
	private $isTransmitter = false;
	
	/**
	 * @var int $quantity
	 * 
	 * @ORM\Column(name="quantity", type="integer")
	 */
	private $quantity = 1;
	
	/**
	 * Prix d'achat HT
	 * @var float $purchase
	 *
	 * @ORM\Column(name="purchase",type="decimal", scale=2)
	 */
	private $purchase;
	
	/**
	 * Taux de remise fournisseur (en %)
	 * @var int $discountSupplier
	 *
	 * @ORM\Column(name="discount_supplier", type="smallint")
	 */
	private $discountSupplier;
	
	/**
	 * Taux de remise (en %)
	 * @var int $discount
	 *
	 * @ORM\Column(name="discount", type="smallint")
	 */
	private $discount;
	
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
	 * TVA applicable (en %)
	 * TVA sur tout les produit sauf les emetteurs
	 * @var float $vat
	 *
	 * @ORM\Column(name="vat", type="decimal",precision=3,scale=3)
	 */
	private $vat;

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
     * Set position
     *
     * @param integer $position
     * @return CodingLine
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return CodingLine
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    
        return $this;
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
     * Set designation
     *
     * @param string $designation
     * @return CodingLine
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    
        return $this;
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
     * Set isTransmitter
     *
     * @param boolean $isTransmitter
     * @return CodingLine
     */
    public function setIsTransmitter($isTransmitter)
    {
        $this->isTransmitter = $isTransmitter;
    
        return $this;
    }

    /**
     * Get isTransmitter
     *
     * @return boolean 
     */
    public function getIsTransmitter()
    {
        return $this->isTransmitter;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return CodingLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set purchase
     *
     * @param float $purchase
     * @return CodingLine
     */
    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
    
        return $this;
    }

    /**
     * Get purchase
     *
     * @return float 
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

    /**
     * Set discountSupplier
     *
     * @param integer $discountSupplier
     * @return CodingLine
     */
    public function setDiscountSupplier($discountSupplier)
    {
        $this->discountSupplier = $discountSupplier;
    
        return $this;
    }

    /**
     * Get discountSupplier
     *
     * @return integer 
     */
    public function getDiscountSupplier()
    {
        return $this->discountSupplier;
    }

    /**
     * Set discount
     *
     * @param integer $discount
     * @return CodingLine
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    
        return $this;
    }

    /**
     * Get discount
     *
     * @return integer 
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set expenseRatio
     *
     * @param integer $expenseRatio
     * @return CodingLine
     */
    public function setExpenseRatio($expenseRatio)
    {
        $this->expenseRatio = $expenseRatio;
    
        return $this;
    }

    /**
     * Get expenseRatio
     *
     * @return integer 
     */
    public function getExpenseRatio()
    {
        return $this->expenseRatio;
    }

    /**
     * Set shipping
     *
     * @param float $shipping
     * @return CodingLine
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    
        return $this;
    }

    /**
     * Get shipping
     *
     * @return float 
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set vat
     *
     * @param float $vat
     * @return CodingLine
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    
        return $this;
    }

    /**
     * Get vat
     *
     * @return float 
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Set coding
     *
     * @param JLM\OfficeBundle\Entity\Coding $coding
     * @return CodingLine
     */
    public function setCoding(\JLM\OfficeBundle\Entity\Coding $coding = null)
    {
        $this->coding = $coding;
    
        return $this;
    }

    /**
     * Get coding
     *
     * @return JLM\OfficeBundle\Entity\Coding 
     */
    public function getCoding()
    {
        return $this->coding;
    }

    /**
     * Set product
     *
     * @param JLM\ModelBundle\Entity\Product $product
     * @return CodingLine
     */
    public function setProduct(\JLM\ModelBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return JLM\ModelBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}