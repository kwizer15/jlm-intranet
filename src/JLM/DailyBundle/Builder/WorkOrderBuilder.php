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
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class WorkOrderBuilder extends OrderBuilderAbstract
{
    private $intervention;
    
    /**
     * 
     * @param Work $intervention
     * @throws LogicException
     */
    public function __construct(WorkInterface $intervention, $options = array())
    {
        if ($intervention->getQuote() === null)
        {
            throw new LogicException('Aucun devis lié a ces travaux');
        }
        parent::__construct($options);
        $this->intervention = $intervention;
    }
    
    public function buildLines()
    {
    	$this->setCreation(new \DateTime);
    	$this->setWork($work);
    	if ($variant = $work->getQuote())
    	{
    		$vlines = $variant->getLines();
    		$hours = 0;
    		foreach ($vlines as $vline)
    		{
    			$flag = true;
    			if ($product = $vline->getProduct())
    			{
    				if ($category = $product->getCategory())
    				{
    					if ($category->isService())
    					{
    						$hours += $vline->getQuantity();
    						$flag = false;
    					}
    				}
    			}
    			if ($flag)
    			{
    				$oline = new OrderLine;
    				$oline->setReference($vline->getReference());
    				$oline->setQuantity($vline->getQuantity());
    				$oline->setDesignation($vline->getDesignation());
    				$this->addLine($oline);
    			}
    		}
    		$this->setTime($hours);
    	}
    }
}
