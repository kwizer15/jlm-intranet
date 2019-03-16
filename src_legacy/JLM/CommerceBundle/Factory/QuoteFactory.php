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

use JLM\CommerceBundle\Builder\QuoteBuilderInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteFactory
{
    /**
     *
     * @param QuoteBuilderInterface $bill
     *
     * @return QuoteInterface
     */
    public static function create(QuoteBuilderInterface $builder)
    {
        $builder->create();
        $builder->buildCreation();
        $builder->buildLines();
        $builder->buildCustomer();
        $builder->buildBusiness();
        $builder->buildIntro();
        $builder->buildConditions();
        
        return $builder->getQuote();
    }
}
