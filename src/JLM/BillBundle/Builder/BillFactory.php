<?php

/*
 * This file is part of the JLMBillBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\BillBundle\Builder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillFactory
{
    /**
     * 
     * @param BillBuilderInterface $bill
     * 
     * @return BillInterface
     */
    public static function create(BillBuilderInterface $builder)
    {
        $builder->create();
        $builder->buildCreation();
        $builder->buildLines();
        $builder->buildCustomer();
        $builder->buildBusiness();
        $builder->buildReference();
        $builder->buildIntro();
        $builder->buildDetails();
        $builder->buildConditions();
        
        return $builder->getBill();
    }
}