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

use JLM\DailyBundle\Entity\Work;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class WorkBuilderAbstract implements WorkBuilderInterface
{
    /**
     * @var Work
     */
    protected $work;
    
    /**
     * @var array
     */
    protected $options;
    
    /**
     * {@inheritdoc}
     */
    public function getWork()
    {
        return $this->work;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->work = new Work;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCreation()
    {
        $this->work->setCreation(new \DateTime);
        // Changer ça : définitien de "creation" dans le lifecyclecallback de doctrine
    }
    
    public function buildPriority()
    {
        $this->work->setPriority(3);
    }
    
    public function buildOrder()
    {
    }
    
    /**
     * Constructor
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->options = $options;
    }
    
    /**
     * Get the options
     * @return array
     */
    protected function getOptions()
    {
        return $this->options;
    }
    
    /**
     * Get an option
     * @param string $key
     * @return mixed|null
     */
    protected function getOption($key)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }
        
        return null;
    }
}
