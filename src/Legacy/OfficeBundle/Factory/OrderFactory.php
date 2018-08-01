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

use JLM\OfficeBundle\Builder\OrderBuilderInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class OrderFactory
{
    /**
     * 
     * @param BillBuilderInterface $bill
     * 
     * @return BillInterface
     */
    public static function create(OrderBuilderInterface $builder)
    {
        $builder->create();
        $builder->buildCreation();
        $builder->buildTime();
        $builder->buildLines();
     
        return $builder->getOrder();
    }
}