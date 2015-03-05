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

use JLM\OfficeBundle\Builder\OrderBuilderAbstract;
use JLM\CommerceBundle\Model\QuoteVariantInterface;
use JLM\OfficeBundle\Factory\OrderLineFactory;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VariantOrderBuilder extends OrderBuilderAbstract
{
    private $variant;
    
    /**
     * 
     * @param QuoteVariantInterface $intervention
     * @throws LogicException
     */
    public function __construct(QuoteVariantInterface $variant, $options = array())
    {
        parent::__construct($options);
        $this->variant = $variant;
    }
    
    public function buildLines()
    {
    	$vlines = $this->variant->getLines();
    	foreach ($vlines as $vline)
    	{
    		if (!$vline->isService())
    		{
    			$this->getOrder()->addLine(OrderLineFactory::create(new VariantOrderLineBuilder($vline)));
    		}
    	}
    }
    
    public function buildTime()
    {
    	parent::buildTime();
    	$vlines = $this->variant->getLines();
    	$hours = 0;
    	foreach ($vlines as $vline)
    	{
    		if ($vline->isService())
    		{
    			$hours += $vline->getQuantity();
    		}
    	}
    	$this->getOrder()->setTime($hours);
    }
}
