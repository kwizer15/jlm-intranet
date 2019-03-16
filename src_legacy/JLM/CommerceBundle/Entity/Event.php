<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Entity;

use JLM\CommerceBundle\Model\EventInterface;

class Event implements EventInterface
{
   
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var \DateTime
     */
    private $date;
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var array
     */
    private $options = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDate();
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     *
     * @param \DateTime $date
     * @return self
     */
    public function setDate(\DateTime $date = null)
    {
        $this->date = ($date === null) ? new \DateTime : $date;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getOption($name, $default = null)
    {
        return isset($this->option[$name]) ? $this->option[$name] : $default;
    }
    
    /**
     * @param string $name
     * @param string $value
     * @return boolean
     */
    public function addOption($name, $value)
    {
        if (is_string($name) && is_string($value)) {
            $this->options[$name] = $value;
            
            return true;
        }
        
        return false;
    }
    
    /**
     * @param array $options
     * @return self
     */
    public function setOptions(array $options)
    {
        $this->options = [];
        foreach ($options as $name => $value) {
            $this->addOption($name, $value);
        }
        
        return $this;
    }
}
