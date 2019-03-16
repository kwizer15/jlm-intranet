<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Builder;

use JLM\DailyBundle\Model\InterventionInterface;
use JLM\CommerceBundle\Model\QuoteVariantInterface;
use JLM\OfficeBundle\Factory\OrderFactory;
use JLM\CommerceBundle\Builder\VariantOrderBuilder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VariantWorkBuilder extends WorkBuilderAbstract
{
    private $variant;
    
    public function __construct(QuoteVariantInterface $variant, $options = [])
    {
        $this->variant = $variant;
        parent::__construct($options);
    }
    
    public function buildBusiness()
    {
        $door = $this->variant->getQuote()->getDoor();
        $this->getWork()->setDoor($door);
        $this->getWork()->setPlace($door.'');
        $this->getWork()->setContract($door->getActualContract().'');
    }
    
    public function buildReason()
    {
        $ask = $this->variant->getQuote()->getAsk();
        $this->getWork()->setReason(($ask !== null) ? $this->variant->getIntro() : $ask()->getAsk());
        
        if (isset($this->options['category'])) {
            $this->getWork()->setCategory($this->options['category']);
        }
        if (isset($this->options['objective'])) {
            $this->getWork()->setObjective($this->options['objective']);
        }
    }
    
    public function buildContact()
    {
        $quote = $this->variant->getQuote();
        $this->getWork()->setContactName($quote->getContactCp());
        if ($quote->getContact()) {
            $this->getWork()->setContactPhones(
                $quote->getContact()->getPerson()->getFixedPhone().chr(10)
                    .$quote->getContact()->getPerson()->getMobilePhone()
            );
        }
    }
    
    public function buildOrder()
    {
        $order = OrderFactory::create(new VariantOrderBuilder($this->variant));
        $this->getWork()->setOrder($order);
    }
    
    public function buildLink()
    {
        $this->getWork()->setQuote($this->variant);
    }
}
