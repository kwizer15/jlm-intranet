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
abstract class BillBuilderAbstract implements BillBuilderInterface
{
    private $bill;
    
    public function getBill()
    {
        return $this->bill;
    }
    
    public function create()
    {
        $this->bill = new Bill;
    }
    
    public function buildCreation()
    {
        $this->bill->setCreation(new \DateTime);
    }
    
    public function buildIntro() {}
    
    public function buildDetails() {}
}