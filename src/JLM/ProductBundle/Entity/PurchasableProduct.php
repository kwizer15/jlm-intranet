<?php
namespace JLM\ProductBundle\Entity;

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
	 */
	public function __construct(ProductInterface $product, $publicPrice)
	{
		parent::__construct($product);
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
		return $this->purchasePrices->getPublicPrice()->getValue();
	}

	public function setPublicPrice($price)
	{
		$this->addPurchasePrices(0,$price);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getPuchaseUnitPrice($quantity = 1)
	{
		return $this->purchasePrices->get($quantity);
	}

	/**
	 * {@inheritdoc}
	 */
	public function addPurchaseUnitPrice($quantity, $price)
	{
		$this->purchasePrices->add($quantity, PriceFactory::create($price));
		
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
}