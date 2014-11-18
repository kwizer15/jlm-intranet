<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Builder;

use JLM\CommerceBundle\Builder\BillLineBuilderAbstract;
use JLM\ProductBundle\Model\ProductInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductBillLineBuilder extends BillLineBuilderAbstract
{
	private $product;
	private $quantity;
	private $options = array();
	
	public function __construct(ProductInterface $product, $vat, $quantity = 1, $options = array())
	{
		$this->product = $product;
		$this->quantity = $quantity;
		$this->options = $options;
		$this->vat = $vat;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildPrice()
	{
		$price = isset($this->options['price']) ? $this->options['price'] : $this->product->getUnitPrice($this->quantity);
		$this->getLine()->setUnitPrice($price);
		$this->getLine()->setVat($this->vat);
	}

	public function buildProduct()
	{
		$this->getLine()->setProduct($this->product);
		$this->getLine()->setReference($this->product->getReference());
		$this->getLine()->setIsTransmitter($this->product->isSmallSupply());
		$desig = isset($this->options['designation']) ? $this->options['designation'] : $this->product->getDesignation();
		$this->getLine()->setDesignation($desig);
		$descr = isset($this->options['description']) ? $this->options['description'] : $this->product->getDescription();
		$this->getLine()->setDescription($descr);
		$this->getLine()->setShowDescription(!empty($descr));
	}
	
	public function buildQuantity()
	{
		$this->getLine()->setQuantity($this->quantity);
	}
}