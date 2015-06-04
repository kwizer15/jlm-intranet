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

use JLM\CommerceBundle\Entity\Quote;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class QuoteBuilderAbstract implements QuoteBuilderInterface
{
    /**
     * @var Quote
     */
    protected $quote;
    
    /**
     * @var array
     */
    protected $options;
    
    /**
     * {@inheritdoc}
     */
    public function getQuote()
    {
        return $this->quote;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->quote = new Quote;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCreation()
    {
        $this->quote->setCreation(new \DateTime);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildIntro() {}
    
    /**
     * {@inheritdoc}
     */
    public function buildDetails() {}
    
    /**
     * {@inheritdoc}
     */
    public function buildConditions()
    {
        foreach ($this->options as $key => $value)
        {
            switch ($key)
            {
            	case 'vatTransmitter':
            	    $this->quote->setVatTransmitter($value);
            	    break;
            	case 'vat':
            	    $this->quote->setVat($value);
            	    break;
            }
        }
    }
    
    public function __construct($options = array())
    {
        $this->options = $options;
    }
    
    protected function getOptions()
    {
        return $this->options;
    }
    
    protected function getOption($key)
    {
        if (isset($this->options[$key]))
        {
            return $this->options[$key];
        }
        
        return null;
    }
}