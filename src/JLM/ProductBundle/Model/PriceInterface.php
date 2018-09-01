<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface PriceInterface
{
    /**
     * Get quantity
     *
     * @return integer
     */
    public function getMinimumQuantity();
    
    /**
     * Get unitPrice
     *
     * @return float
    */
    public function getUnitPrice();
}
