<?php

/*
 * This file is part of the JLMAskBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\AskBundle\Entity;

use JLM\AskBundle\Model\CommunicationMeansInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CommunicationMeans implements CommunicationMeansInterface
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string
     */
    private $name = '';
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set text
     *
     * @param string $text
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * Get text
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
        return $this->getName();
    }
}
