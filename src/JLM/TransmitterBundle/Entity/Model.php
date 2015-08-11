<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;
use JLM\CommerceBundle\Entity\TextModel;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Model extends TextModel
{
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * Set product
     *
     * @param ProductInterface $product
     * @return Model
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
    
}