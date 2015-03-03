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
	    $this->getWork()->setPlace($this->intervention->getPlace());
	    $this->getWork()->setDoor($this->intervention->getDoor());
	    $this->getWork()->setContract($this->intervention->getDoor()->getActualContract().'');
    }
    
    public function buildReason()
    {
    	$this->getWork()->setReason($this->intervention->getRest());
    	if (isset($this->options['category']))
    	{
    		$this->getWork()->setCategory($this->options['category']);
    	}
    	if (isset($this->options['objective']))
    	{
    		$this->getWork()->setObjective($this->options['objective']);
    	}
    }
    
    public function buildContact()
    {
    	$this->getWork()->setContactName($this->intervention->getContactName());
    	$this->getWork()->setContactPhones($this->intervention->getContactPhones());
    	$this->getWork()->setContactEmail($this->intervention->getContactEmail());
    }
    
    public function buildLink()
    {
    	$this->getWork()->setIntervention($this->intervention);
    }
}