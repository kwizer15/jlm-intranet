<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Factory;

use JLM\OfficeBundle\Builder\OrderLineBuilderInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class OrderLineFactory
{
    
    public static function create(OrderLineBuilderInterface $builder)
    {
        $builder->create();
        $builder->buildReference();
        $builder->buildQuantity();
        $builder->buildDesignation();
    
        return $builder->getLine();
    }
}