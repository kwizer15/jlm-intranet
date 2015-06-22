<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;
use JLM\CommerceBundle\Model\CommercialPartLineProductInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class CommercialPartLineProduct extends CommercialPartLine implements CommercialPartLineProductInterface
{
	/**
	 * Position de la ligne dans le devis
	 * @var position
	 */
	private $position = 0;
	
	/**
	 * @var ProductInterface
	 */
	private $product;
	
	/**
	 * @var string $reference
	 */
	private $reference;
	
	/**
	 * @var string $designation
	 */
	private $designation;
	
	/**
	 * @var string $description
	 */
	private $description;
	
	/**
	 * @var bool $showDescription
	 */
	private $showDescription;
	
	/**
	 * @var bool $isTransmitter
	 */
	private $isTransmitter = false;
	
	/**
	 * @var int $quantity
	 */
	private $quantity = 1;
	
	/**
	 * Prix de vente unitaire (€)
	 * NB : Pas de coefficient, celui-ci est calculé
	 * via PA total (inclue remise fournisseur, frais,
	 * port) et PV
	 *
	 * @var float $unitPrice
	 */
	private $unitPrice = 0;
	
	/**
	 * Remise (%)
	 * @var float $discount
	 */
	private $discount = 0;
	
	/**
	 * TVA applicable (en %)
	 * TVA sur tout les produit sauf les emetteurs
	 * @var float $vat
	 */
	private $vat;
	
	/**
	 * Set position
	 *
	 * @param int $position
	 * @return self
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
	 * @return self
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
	 * @return self
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
	 * @return self
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
	 * @return self
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
	 * @return self
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
		if ($this->getReference() == 'ST')
		{
			return 0;
		}
		return $this->quantity;
	}
	
	/**
	 * Set unitPrice
	 *
	 * @param float $unitPrice
	 * @return self
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
	 * @return self
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
	 * 
	 * @return float
	 */
	public function getSellPrice()
	{
		return $this->getUnitPrice()*(1-$this->getDiscount());
	}
	
	/**
	 * Set vat
	 *
	 * @param float $vat
	 * @return self
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
	 * @return self
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
	 * @return self
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