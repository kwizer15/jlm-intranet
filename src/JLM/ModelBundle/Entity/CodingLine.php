<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\CodingLine
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
	 * @var integer $position
	 * 
	 * @ORM\Column(name="position", type="smallint")
	 */
	private $position;
	
	/**
	 * Lien vers le produit
	 * @var Product $product
	 * 
	 * @ORM\ManyToOne(targetEntity="Product")
	 */
	private $product;
	
	/**
	 * Copie de la référence
	 * @var string $reference
	 * 
	 * @ORM\Column(name="reference", type="string", length=16)
	 */
	private $reference;
	
	/**
	 * Copie de la designation
	* @var string $designation
	*
	* @ORM\Column(name="designation", type="string", length=255)
	*/
	private $designation;
	
	/**
	 * Copie de la description longue
	 * @var string $description
	 *
	 * @ORM\Column(name="description", type="text")
	 */
	private $description;
	
	/**
	 * Montre la description longue
	 * @var bool $showDescription
	 * 
	 * @ORM\Column(name="show_description",type="boolean")
	 */
	private $showDescription;
	
    /**
     * @var smallint $quantity
     *
     * @ORM\Column(name="quantity", type="smallint")
     */
    private $quantity;

    /**
     * @var smallint $vat
     *
     * @ORM\Column(name="vat", type="decimal", scale=1)
     */
    private $vat;

    /**
     * Taux de remise (%)
     * @var float $discount
     * 
     * @ORM\Column(name="discount",type="decimal", scale=7)
     */
    private $discount;
    
    /**
     * @var integer $unitPrice
     *
     * @ORM\Column(name="unitPrice", type="decimal", scale=2)
     */
    private $unitPrice;

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
     * Set description
     *
     * @param string $description
     * @return CodingLine
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set showDescription
     *
     * @param boolean $showDescription
     * @return CodingLine
     */
    public function setShowDescription($showDescription)
    {
        $this->showDescription = $showDescription;
    
        return $this;
    }

    /**
     * Get showDescription
     *
     * @return boolean 
     */
    public function getShowDescription()
    {
        return $this->showDescription;
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
     * Set discount
     *
     * @param float $discount
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
     * @return float 
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set unitPrice
     *
     * @param float $unitPrice
     * @return CodingLine
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    
        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return float 
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
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
}