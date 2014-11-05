<?php
namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ProductBundle\Model\ProductInterface;

/**
 * JLM\OfficeBundle\Entity\DocumentLine
 * @ORM\MappedSuperclass
 */
class DocumentLine
{
	/**
	 * Position de la ligne dans le devis
	 * @var position
	 *
	 * @ORM\Column(name="position", type="smallint", nullable=true)
	 */
	private $position = 0;
	
	/**
	 * @var ProductInterface
	 * @ORM\ManyToOne(targetEntity="JLM\ProductBundle\Model\ProductInterface")
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
	 * @var string $description
	 *
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;
	
	/**
	 * @var bool $showDescription
	 *
	 * @ORM\Column(name="show_description", type="boolean", nullable=true)
	 */
	private $showDescription;
	
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
	 * Prix de vente unitaire (€)
	 * NB : Pas de coefficient, celui-ci est calculé
	 * via PA total (inclue remise fournisseur, frais,
	 * port) et PV
	 *
	 * @var float $unitPrice
	 *
	 * @ORM\Column(name="unit_price", type="decimal",scale=2)
	 */
	private $unitPrice = 0;
	
	/**
	 * Remise (%)
	 * @var float $discount
	 *
	 * @ORM\Column(name="discount", type="decimal",scale=7)
	 */
	private $discount = 0;
	
	/**
	 * TVA applicable (en %)
	 * TVA sur tout les produit sauf les emetteurs
	 * @var float $vat
	 *
	 * @ORM\Column(name="vat", type="decimal",precision=3,scale=3)
	 */
	private $vat;
	
	/**
	 * Set position
	 *
	 * @param int $position
	 * @return QuoteLine
	 */
	public function setPosition($position)
	{
		$this->position = $position;
	
		return $this;
	}
	
	/**
	 * Get position
	 *
	 * @return int
	 */
	public function getPosition()
	{
		return $this->position;
	}
	
	/**
	 * Set reference
	 *
	 * @param string $reference
	 * @return QuoteLine
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
	 * @return QuoteLine
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
	 * @return QuoteLine
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
	 * @return QuoteLine
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
	 * @return QuoteLine
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
	 * Set unitPrice
	 *
	 * @param float $unitPrice
	 * @return QuoteLine
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
	 * Set discount
	 *
	 * @param float $discount
	 * @return QuoteLine
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
	 * Get sellPrice
	 */
	public function getSellPrice()
	{
		return $this->getUnitPrice()*(1-$this->getDiscount());
	}
	
	/**
	 * Set vat
	 *
	 * @param float $vat
	 * @return QuoteLine
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
	 * Set product
	 *
	 * @param ProductInterface $product
	 * @return QuoteLine
	 */
	public function setProduct(ProductInterface $product = null)
	{
		$this->product = $product;
	
		return $this;
	}
	
	/**
	 * Get product
	 *
	 * @return ProductInterface
	 */
	public function getProduct()
	{
		return $this->product;
	}
	
	/**
	 * Get Total HT
	 *
	 * @return float
	 */
	public function getPrice()
	{
		return ($this->getUnitPrice() * $this->getQuantity()) * (1 - $this->getDiscount());
	}
	
	/**
	 * Get Total TVA
	 *
	 * @return float
	 */
	public function getVatValue()
	{
		return $this->getPrice()*$this->getVat();
	}
	
	/**
	 * Get Total TTC
	 */
	public function getPriceAti()
	{
		return $this->getPrice()*(1 + $this->getVat());
	}
	
	/**
	 * Set Is Transmitter
	 *
	 * @param bool $tr
	 * @return Quote
	 */
	public function setIsTransmitter($tr)
	{
		$this->isTransmitter = (bool)$tr;
		return $this;
	}
	
	/**
	 * Get Is Transmitter
	 *
	 * @return bool
	 */
	public function getIsTransmitter()
	{
		return $this->isTransmitter;
	}
	
	/**
	 * Is Service
	 *
	 * @return boolean
	 */
	public function isService()
	{
		if ($this->getProduct() === null)
		{
			return false;
		}
		return $this->getProduct()->getCategory()->isService();
	}
}