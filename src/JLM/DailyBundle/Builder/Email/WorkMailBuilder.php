<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Builder\Email;

use JLM\CoreBundle\Builder\MailBuilderAbstract;
use JLM\DailyBundle\Model\WorkInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class WorkMailBuilder extends InterventionMailBuilder
{
    public function __construct(WorkInterface $work)
    {
        parent::__construct($work);
    }
    
    public function getWork()
    {
        return $this->getIntervention();
    }
    
    protected function getSource()
    {
        $quote = $this->getWork()->getQuote();
        if (!empty($quote)) {
            return ' selon devis n°'.$quote->getNumber();
        }
        
        $intervention = $this->getWork()->getIntervention();
        if (!empty($intervention)) {
            return ' selon intervention du '.$intervention->getLastDate()->format('d/m/Y');
        }
    
        return null;
    }
}
