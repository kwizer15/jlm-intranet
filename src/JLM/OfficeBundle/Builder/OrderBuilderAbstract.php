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

use JLM\OfficeBundle\Entity\Order;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class OrderBuilderAbstract implements OrderBuilderInterface
{
    /**
     * @var Order
     */
    protected $order;
    
    /**
     * @var array
     */
    protected $options;
    
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->order = new Order;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCreation()
    {
        $this->order->setCreation(new \DateTime);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildLines()
    {
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildTime()
    {
        $this->order->setTime(0);
    }
    
    /**
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }
    
    /**
     *
     * @return multitype:
     */
    protected function getOptions()
    {
        return $this->options;
    }
    
    protected function getOption($key)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }
        
        return null;
    }
}
