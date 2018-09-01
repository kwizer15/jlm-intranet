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

use JLM\ModelBundle\Builder\DoorBillBuilderAbstract;
use JLM\CommerceBundle\Factory\BillLineFactory;
use JLM\CommerceBundle\Model\QuoteVariantInterface;
use JLM\ModelBundle\Entity\Door;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VariantBillBuilder extends DoorBillBuilderAbstract
{
    private $variant;
    
    public function __construct(QuoteVariantInterface $variant, $options = [])
    {
        $this->variant = $variant;
        parent::__construct($variant->getDoor(), $options);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildReference()
    {
        $this->bill->setReference('Selon votre accord sur notre devis n°'.$this->variant->getNumber());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildLines()
    {
        $lines = $this->variant->getLines();
        foreach ($lines as $line) {
            $l = BillLineFactory::create(new VariantBillLineBuilder($line));
            $l->setBill($this->bill);
            $l->setPosition($line->getPosition());
            $this->bill->addLine($l);
        }
    }
}
