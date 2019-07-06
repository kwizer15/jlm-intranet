<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Model;

use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Entity\Site;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface QuoteVariantInterface
{
	/**
	 * @return int
	 */
	public function getState();
	
	/**
	 * @param QuoteInterface|null $quote
	 * @return self
	 */
	public function setQuote(QuoteInterface $quote = null);
	
	/**
	 * @param int $number
	 * @return self
	 */
	public function setVariantNumber($number);
	
	/**
	 * @return array
	 */
	public function getLines();
	
	/**
	 * @return Door
	 */
	public function getDoor();
	
	/**
	 * @return Site
	 */
	public function getSite();
	
	/**
	 * @return string
	 */
	public function getNumber();
	
	public function getTotalPrice();
	
	/**
	 * @param string $type
	 * @return bool
	 */
	public function hasLineType($type);
	
	/**
	 * @param string $type
	 * @return QuoteLineInterface[]
	 */
	public function	getLinesByType($type);

	public function getQuote();
}