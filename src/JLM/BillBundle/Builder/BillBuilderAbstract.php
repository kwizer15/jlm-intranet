<?php

/*
 * This file is part of the JLMBillBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\BillBundle\Builder;

use JLM\CommerceBundle\Entity\Bill;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class BillBuilderAbstract implements BillBuilderInterface
{
    /**
     * @var Bill
     */
    private $bill;
    
    /**
     * @var array
     */
    private $options;
    
    /**
     * {@inheritdoc}
     */
    public function getBill()
    {
        return $this->bill;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->bill = new Bill;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCreation()
    {
        $this->bill->setCreation(new \DateTime);
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
        if (!isset($this->options['maturity']))
        {
            $this->options['maturity'] = 30;
        }
        
        foreach ($this->options as $key => $value)
        {
            switch ($key)
            {
            	case 'earlyPayment':
            	    $this->getBill()->setEarlyPayment($value);
            	    break;
            	case 'penalty':
            	    $this->getBill()->setPenalty($value);
            	    break;
            	case 'property':
            	    $this->getBill()->setProperty($value);
            	    break;
            	case 'maturity':
            	    $this->getBill()->setMaturity($value);
            	    break;
            	case 'vatTransmitter':
            	    $this->getBill()->setVatTransmitter($value);
            	    break;
            	case 'vat':
            	    $this->getBill()->setVat($value);
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