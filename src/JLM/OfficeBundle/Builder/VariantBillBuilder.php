<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Builder;

use JLM\BillBundle\Builder\BillBuilderAbstract;
use JLM\OfficeBundle\Entity\QuoteVariant;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VariantBillBuilder extends BillBuilderAbstract
{
    private $variant;
    
    public function __construct(QuoteVariant $variant)
    {
        $this->variant = $variant;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildLines()
    {
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCustomer()
    {
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildBusiness()
    {
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildConditions()
    {
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildDetails()
    {
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildReference()
    {
        $this->getBill()->setReference('Selon votre accord sur notre devis n°'.$this->variant->getNumber());
    }
}