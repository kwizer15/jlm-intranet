<?php

/*
 * This file is part of the JLMFollowBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FollowBundle\Entity;

use JLM\CommerceBundle\Model\QuoteVariantInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class StarterQuote extends Starter
{
	/**
	 * @var QuoteVariantInterface
	 */
	private $variant;
	
	public function __construct(QuoteVariantInterface $variant)
	{
		$this->setVariant($variant);
	}
	
	/**
	 * @param QuoteVariantInterface $variant
	 * @return self
	 */
	public function setVariant(QuoteVariantInterface $variant)
	{
		$this->variant = $variant;
		
		return $this;
	}
	
	/**
	 * @return QuoteVariantInterface
	 */
	public function getVariant()
	{
		return $this->variant;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'Devis n°'.$this->getVariant()->getNumber();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getBusiness()
	{
		return $this->getVariant()->getDoor();
	}
	
	public function getAmount()
	{
		return $this->getVariant()->getTotalPrice();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getType()
	{
		return 'quote';
	}
}