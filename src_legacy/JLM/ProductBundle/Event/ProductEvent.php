<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use JLM\ProductBundle\Model\ProductInterface;
use Symfony\Component\EventDispatcher\Event;

class ProductEvent extends Event
{
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }
    
    public function getProduct()
    {
        return $this->product;
    }
}
