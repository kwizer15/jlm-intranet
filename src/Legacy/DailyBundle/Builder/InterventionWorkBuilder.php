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

use JLM\DailyBundle\Model\InterventionInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class InterventionWorkBuilder extends WorkBuilderAbstract
{
    private $intervention;
    
    public function __construct(InterventionInterface $intervention, $options = array())
    {
        $this->intervention = $intervention;
        parent::__construct($options);
    }
    
    public function buildBusiness()
    {
    	$work = $this->getWork();
	    $work->setPlace($this->intervention->getPlace());
	    $work->setDoor($this->intervention->getDoor());
	    $work->setContract($this->intervention->getDoor()->getActualContract().'');
    }
    
    public function buildReason()
    {
    	$work = $this->getWork();
    	$work->setReason($this->intervention->getRest());
    	if (isset($this->options['category']))
    	{
    		$work->setCategory($this->options['category']);
    	}
    	if (isset($this->options['objective']))
    	{
    		$work->setObjective($this->options['objective']);
    	}
    }
    
    public function buildContact()
    {
    	$work = $this->getWork();
    	$work->setContactName($this->intervention->getContactName());
    	$work->setContactPhones($this->intervention->getContactPhones());
    	$work->setContactEmail($this->intervention->getContactEmail());
    }
    
    public function buildLink()
    {
    	$this->getWork()->setIntervention($this->intervention);
    }
}