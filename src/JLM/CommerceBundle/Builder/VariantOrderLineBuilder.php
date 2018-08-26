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

use JLM\CommerceBundle\Entity\QuoteLine;
use JLM\OfficeBundle\Builder\OrderLineBuilderAbstract;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VariantOrderLineBuilder extends OrderLineBuilderAbstract
{
    private $l;
    
    public function __construct(QuoteLine $line)
    {
        $this->l = $line;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildReference()
    {
        $this->getLine()->setReference($this->l->getReference());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildDesignation()
    {
        $this->getLine()->setDesignation($this->l->getDesignation());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildQuantity()
    {
        $this->getLine()->setQuantity($this->l->getQuantity());
    }
}
