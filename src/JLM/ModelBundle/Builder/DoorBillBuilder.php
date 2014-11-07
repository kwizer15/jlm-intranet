<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Builder;

use JLM\ModelBundle\Entity\Door;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DoorBillBuilder extends DoorBillBuilderAbstract
{
    private $door;
    
    public function __construct(Door $door, $options = array())
    {
        $this->door = $door;
        parent::__construct($options);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _getDoor()
    {
        return $this->door;
    }
    
    public function buildLines()
    {
        
    }
    
    public function buildReference()
    {
        
    }
}