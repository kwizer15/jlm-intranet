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

use JLM\DailyBundle\Model\WorkInterface;
use JLM\OfficeBundle\Builder\OrderBuilderAbstract;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use JLM\OfficeBundle\Entity\OrderLine;
use JLM\OfficeBundle\Factory\OrderLineFactory;
use JLM\CommerceBundle\Builder\VariantOrderLineBuilder;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class WorkOrderBuilder extends OrderBuilderAbstract
{
    private $work;
    
    /**
     * 
     * @param Work $intervention
     * @throws LogicException
     */
    public function __construct(WorkInterface $work, $options = array())
    {
        parent::__construct($options);
        $this->work = $work;
    }
    
    public function buildLines()
    {
    	if ($variant = $this->work->getQuote())
    	{
    		$vlines = $variant->getLines();
    		foreach ($vlines as $vline)
    		{
    			if (!$vline->isService())
    			{
    				$this->getOrder()->addLine(OrderLineFactory::create(new VariantOrderLineBuilder($vline)));
    			}
    		}
    	}
    }
    
    public function buildTime()
    {
    	parent::buildTime();
    	if ($variant = $this->work->getQuote())
    	{
    		$vlines = $variant->getLines();
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
    
    public function buildWork()
    {
    	$this->getOrder()->setWork($this->work);
    }
}
