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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface QuoteLineInterface
{
	/**
	 * 
	 * @param QuoteVariantInterface|null $variant
	 * @return bool
	 */
    public function setVariant(QuoteVariantInterface $variant = null);
    
    /**
     * @return float
     */
    public function getPrice();
    
    /**
     * @return float
     */
    public function getPriceAti();
    
    /**
     * @return float
     */
    public function getTotalPurchasePrice();
    
    /**
     * @return float
     */
    public function getVatValue();
    
}