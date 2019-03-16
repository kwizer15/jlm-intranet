<?php

/*
 * This file is part of the JLMFollowBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FollowBundle\Factory;

use JLM\FollowBundle\Entity\Thread;
use JLM\FollowBundle\Entity\StarterQuote;
use JLM\DailyBundle\Model\InterventionInterface;
use JLM\FollowBundle\Entity\StarterIntervention;
use JLM\CommerceBundle\Entity\QuoteVariant;
use JLM\FollowBundle\Model\ThreadInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ThreadFactory
{
    /**
     * Get thread from source
     * @param mixed $source
     * @return ThreadInterface
     */
    public static function create($source)
    {
        return new Thread(self::createStarter($source));
    }
    
    /**
     * Get starter from source
     * @param mixed $source
     * @throws \LogicException
     * @return JLM\FollowBundle\Model\StarterInterface
     */
    public static function createStarter($source)
    {
        if ($source instanceof QuoteVariant) {
            return new StarterQuote($source);
        }
        
        if ($source instanceof InterventionInterface) {
            return new StarterIntervention($source);
        }
        
        throw new \LogicException('The source of starter is invalid');
    }
}
