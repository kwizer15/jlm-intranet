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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class AskBuilderAbstract implements AskBuilderInterface
{
    /**
     * @var Quote
     */
    protected $ask;
    
    /**
     * @var array
     */
    protected $options;
    
    /**
     * {@inheritdoc}
     */
    public function getAsk()
    {
        return $this->ask;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->ask = new Ask();
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCreation()
    {
        $this->ask->setCreation(new \DateTime);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildTrustee()
    {
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildSite()
    {
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildMethod()
    {
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildMaturity()
    {
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildPerson()
    {
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildAsk()
    {
    }
    
    public function __construct($options = [])
    {
        $this->options = $options;
    }
    
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
