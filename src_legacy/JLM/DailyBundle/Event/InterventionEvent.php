<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Event;

use JLM\DailyBundle\Model\InterventionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class InterventionEvent extends Event
{
    /**
     * @var InterventionInterface
     */
    private $intervention;

    /**
     * @param FormInterface $form
     * @param Request $request
     */
    public function __construct(InterventionInterface $intervention)
    {
        $this->intervention = $intervention;
    }
    
    public function getIntervention()
    {
        return $this->intervention;
    }
}
