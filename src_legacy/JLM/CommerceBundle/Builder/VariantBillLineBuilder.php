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

use JLM\CommerceBundle\Builder\BillLineBuilderAbstract;
use JLM\CommerceBundle\Entity\QuoteLine;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VariantBillLineBuilder extends BillLineBuilderAbstract
{
    private $l;
    
    public function __construct(QuoteLine $line)
    {
        $this->l = $line;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildPrice()
    {
        $this->getLine()->setUnitPrice($this->l->getUnitPrice());
        $this->getLine()->setDiscount($this->l->getDiscount());
        $this->getLine()->setVat($this->l->getVat());
    }
    
    public function buildProduct()
    {
        $this->getLine()->setProduct($this->l->getProduct());
        $this->getLine()->setReference($this->l->getReference());
        $this->getLine()->setDesignation($this->l->getDesignation());
        $this->getLine()->setDescription($this->l->getDescription());
        $this->getLine()->setShowDescription($this->l->getShowDescription());
        $this->getLine()->setIsTransmitter($this->l->getIsTransmitter());
    }
    
    public function buildQuantity()
    {
        $this->getLine()->setPosition($this->l->getPosition());
        $this->getLine()->setQuantity($this->l->getQuantity());
    }
}
