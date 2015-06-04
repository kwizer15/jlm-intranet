<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Builder;

use JLM\TransmitterBundle\Entity\Ask;
use JLM\CommerceBundle\Model\QuoteVariantInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class AskBuilderAbstract implements AskBuilderInterface
{
	private $variant;
	
	/**
	 *
	 * @param QuoteVariantInterface $variant
	 */
	public function __construct(QuoteVariantInterface $variant, $options = array())
	{
		parent::__construct($options);
		$this->variant = $variant;
	}
	
    /**
     * {@inheritdoc}
     */
    public function buildTrustee()
    {
    	$this->getAsk()->setTrustee($this->variant->getQuote()->getTrustee());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildSite()
    {
    	$this->getAsk()->setSite($this->variant->getQuote()->getSite());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildMethod()
    {
    	$this->getAsk()->setMethod($this->variant->getQuote()->getAsk()->getMethod());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildMaturity()
    {
    	$maturity = new \DateTime();
    	$maturity->add(new \DateInterval('P7D'));
    	$this->getAsk()->setMaturity($maturity);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildPerson()
    {
    	$this->getAsk()->setPerson($this->variant->getQuote()->getAsk()->getPerson());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildAsk()
    {
    	$ask = 'Selon accord sur devis n°'. $this->variant->getNumber().chr(10);
    	$lines = $this->variant->getLinesByType('TRANSMITTER');
    	foreach ($lines as $line)
    	{
    		$ask .= $line->getQuantity(). ' '.$line->getDesignation().chr(10);
    	}
    	$this->getAsk()->setAsk($ask);
    }
}