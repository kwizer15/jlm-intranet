<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JLM\OfficeBundle\Entity\Order;
use JLM\CommerceBundle\Model\QuoteVariantInterface;
use JLM\DailyBundle\Model\WorkInterface;
use JLM\DailyBundle\Factory\WorkFactory;
use JLM\DailyBundle\Builder\InterventionWorkBuilder;
use JLM\DailyBundle\Builder\VariantWorkBuilder;

/**
 * Plannification de travaux
 * JLM\DailyBundle\Entity\Work
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Work extends Intervention implements WorkInterface
{
	/**
	 * Devis source (pour "selon devis...")
	 * @Assert\Valid
	 */
	private $quote;
	
	/**
	 * Work category
	 * @Assert\Valid
	 * @Assert\NotNull
	 */
	private $category;
	
	/**
	 * Work objective
	 * @Assert\Valid
	 * @Assert\NotNull
	 */
	private $objective;
	
	/**
	 * Fiche travaux
	 * @Assert\Valid
	 */
	private $order;
	
	/**
	 * Intervention source
	 */
	private $intervention;
	
	/**
	 * Get work category
	 * @return WorkCategory
	 */
	public function getCategory()
	{
		return $this->category;
	}
	
	/**
	 * Set work category
	 *
	 * @param WorkCategory $category
	 * @return self
	 */
	public function setCategory(WorkCategory $category = null)
	{
		$this->category = $category;
		
		return $this;
	}
	
	/**
	 * Get work objective
	 * @return WorkObjective
	 */
	public function getObjective()
	{
		return $this->objective;
	}
	
	/**
	 * Set work objective
	 *
	 * @param WorkObjective $objective
	 * @return self
	 */
	public function setObjective(WorkObjective $objective = null)
	{
		$this->objective = $objective;
		
		return $this;
	}
	
	/**
	 * Get Type
	 * @see Shifting
	 * @return string
	 */
	public function getType()
	{
		return 'work';
	}

    /**
     * Set order
     *
     * @param \JLM\OfficeBundle\Entity\Order $order
     * @return Work
     */
    public function setOrder(\JLM\OfficeBundle\Entity\Order $order = null)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return \JLM\OfficeBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set quote
     *
     * @param QuoteVariantInterface $quote
     * @return Work
     */
    public function setQuote(QuoteVariantInterface $quote = null)
    {
        $this->quote = $quote;
    
        return $this;
    }

    /**
     * Get quote
     *
     * @return QuoteVariantInterface
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Set intervention
     *
     * @param \JLM\DailyBundle\Entity\Intervention $intervention
     * @return Work
     */
    public function setIntervention(\JLM\DailyBundle\Entity\Intervention $intervention = null)
    {
        $this->intervention = $intervention;
    
        return $this;
    }

    /**
     * Get intervention
     *
     * @return \JLM\DailyBundle\Entity\Intervention 
     */
    public function getIntervention()
    {
        return $this->intervention;
    }
    
    /**
     * Get expected time
     * @return number
     */
    public function getExpectedTime()
    {
    	return  ($order = $this->getOrder()) ? $order->getTime() : 0;
    }
    
    /**
     * Populate from intervention
     * 
     * @param Intervention $interv
     * @return void
     * @deprecated Use WorkFactory::create(new InterventionWorkBuilder($intervention))
     */
    public function populateFromIntervention(Intervention $interv)
    {
    	return self::createFromIntervention($interv);
    }
    
    /**
     * Create from intervention
     *
     * @param Intervention $interv
     * @return void
     * @deprecated Use WorkFactory::create(new InterventionWorkBuilder($intervention))
     */
    public static function createFromIntervention(Intervention $interv)
    {
    	return WorkFactory::create(new InterventionWorkBuilder($interv));
    }
    
    /**
     * Populate from QuoteVariant
     * @param QuoteVariant $variant
     * @return void
     * @deprecated Use WorkFactory::create(new VariantWorkBuilder($variant))
     */
    public function populateFromQuoteVariant(QuoteVariantInterface $variant)
    {
    	return self::createFromQuoteVariant($variant);
    }
    
    /**
     * Create from QuoteVariant
     * 
     * @param QuoteVariant $variant
     * @return \JLM\DailyBundle\Entity\Work
     * @deprecated Use WorkFactory::create(new VariantWorkBuilder($variant))
     */
    public static function createFromQuoteVariant(QuoteVariantInterface $variant)
    {
    	return WorkFactory::create(new VariantWorkBuilder($variant));
    }
}