<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\DocumentContentLine
 *
 * @ORM\Table(name="document_contents_line")
 * @ORM\Entity
 */
class DocumentContentLine extends DocumentContent
{
	
	/**
	 * @var Product $product
	 *
	 * @ORM\ManyToOne(targetEntity="Product")
	 */
	private $product;
	
	/**
	 * @var string $reference
	 * 
	 * @ORM\Column(name="reference", type="string", length=16)
	 */
	private $reference;
	
	/**
	* @var string $designation
	*
	* @ORM\Column(name="designation", type="string", length=255)
	*/
	private $designation;
	
    /**
     * @var smallint $quantity
     *
     * @ORM\Column(name="quantity", type="smallint")
     */
    private $quantity;

    /**
     * @var smallint $vat
     *
     * @ORM\Column(name="vat", type="smallint")
     */
    private $vat;

    /**
     * @var integer $unitPrice
     *
     * @ORM\Column(name="unitPrice", type="integer")
     */
    private $unitPrice;

    /**
     * Set quantity
     *
     * @param smallint $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return smallint 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set vat
     *
     * @param smallint $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * Get vat
     *
     * @return smallint 
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Set unitPrice
     *
     * @param integer $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * Get unitPrice
     *
     * @return integer 
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
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
     * Set product
     *
     * @param JLM\ModelBundle\Entity\Product $product
     */
    public function setProduct(\JLM\ModelBundle\Entity\Product $product)
    {
        $this->product = $product;
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