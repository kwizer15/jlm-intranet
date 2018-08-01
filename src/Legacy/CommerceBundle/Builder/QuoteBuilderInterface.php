<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Builder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface QuoteBuilderInterface
{
    /**
     * @return BillInterface
     */
    public function getQuote();

    public function create();
    
    public function buildCreation();
    
    public function buildLines();
    
    public function buildCustomer();
    
    public function buildBusiness();
    
    public function buildIntro();
    
    public function buildConditions();
}