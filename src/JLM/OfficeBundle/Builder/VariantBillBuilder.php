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

use JLM\ModelBundle\Builder\DoorBillBuilderAbstract;
use JLM\BillBundle\Builder\BillLineFactory;
use JLM\CommerceBundle\Model\QuoteVariantInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VariantBillBuilder extends DoorBillBuilderAbstract
{
    private $variant;
    
    public function __construct(QuoteVariantInterface $variant, $options = array())
    {
        $this->variant = $variant;
        parent::__construct($options);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildReference()
    {
        $this->getBill()->setReference('Selon votre accord sur notre devis n°'.$this->variant->getNumber());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildLines()
    {
        $lines = $this->variant->getLines();
        foreach ($lines as $line)
        {
            $l = BillLineFactory::create(new VariantBillLineBuilder($line));
            $l->setBill($this->getBill());
            $l->setPosition($line->getPosition());
            $this->getBill()->addLine($l);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _getDoor()
    {
        return $this->variant->getDoor();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _getSite()
    {
    	return $this->variant->getSite();
    }
}