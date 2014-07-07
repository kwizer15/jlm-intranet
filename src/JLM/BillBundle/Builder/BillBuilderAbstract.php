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

use JLM\OfficeBundle\Entity\Bill;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class BillBuilderAbstract implements BillBuilderInterface
{
    /**
     * @var Bill
     */
    private $bill;
    
    /**
     * {@inheritdoc}
     */
    public function getBill()
    {
        return $this->bill;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->bill = new Bill;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCreation()
    {
        $this->bill->setCreation(new \DateTime);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildIntro() {}
    
    /**
     * {@inheritdoc}
     */
    public function buildDetails() {}
}