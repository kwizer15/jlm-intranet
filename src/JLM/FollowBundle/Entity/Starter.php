<?php

/*
 * This file is part of the JLMFollowBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FollowBundle\Entity;

use JLM\FollowBundle\Model\StarterInterface;
use JLM\CommerceBundle\Model\QuoteVariantInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class Starter implements StarterInterface
{
    private $id;
    
    private $work;
    
    public function getId()
    {
        return $this->id;
    }
    
    final public function getWork()
    {
        $this->work = $this->getWorkIntervention();
        
        return $this->work;
    }
    
    abstract protected function getWorkIntervention();
}
