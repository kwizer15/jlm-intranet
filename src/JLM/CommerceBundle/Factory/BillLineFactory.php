<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Factory;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillLineFactory
{
    
    public static function create(BillLineBuilderInterface $builder)
    {
        $builder->create();
        $builder->buildProduct();
        $builder->buildQuantity();
        $builder->buildPrice();
    
        return $builder->getLine();
    }
}