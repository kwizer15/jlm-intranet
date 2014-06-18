<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;
use JLM\ProductBundle\Model\PurchasableInterface;
use JLM\ProductBundle\Model\SupplierInterface;

use JLM\ProductBundle\Factory\PriceFactory;

class PurchasableProduct extends ProductDecorator implements PurchasableInterface
{
	/**
	 * 
	 * @var SupplierInterface
	 */
	private $supplier;

	/**
	 * 
	 * @var PriceListInterface
	 */
	private $purchasePrices;
	
	/**
	 * 
	 * @var string
	 */
	private $purchaseUnity;
	
	/**
	 * Constructor
	 * 
	 * @param ProductInterface $product
	 * @param SupplierInterface $supplier
	 * @param decimal $publicPrice
	 */
	public function __construct(ProductInterface $product, SupplierInterface $supplier, $publicPrice, $unity = null)
	{
		parent::__construct($product);
		$this->setSupplier($supplier);
		$this->setPurchaseUnity($unity);
		$this->purchasePrices = PriceFactory::createPriceList($publicPrice);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSupplier()
	{
		return $this->supplier;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setSupplier(SupplierInterface $supplier)
	{
		$this->supplier = $supplier;
		
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPublicPrice()
	{
		return $this->purchasePrices->getValue();
	}

	public function setPublicPrice($price)
	{
		$this->purchasePrices->setValue($price);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getPurchaseUnitPrice($quantity = 1)
	{
		return $this->purchasePrices->get($quantity);
	}

	/**
	 * {@inheritdoc}
	 */
	public function addPurchaseUnitPrice($quantity, $price)
	{
		$this->purchasePrices->add($quantity, $price);
		
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function removePurchaseUnitPrice($quantity)
	{
		$this->purchasePrices->remove($quantity);
		
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPurchaseUnity()
	{
		return $this->purchaseUnity;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setPurchaseUnity($unity)
	{
		$this->purchaseUnity = $unity;
		return $this;
	}
}