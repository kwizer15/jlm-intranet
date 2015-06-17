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
use JLM\DailyBundle\Model\InterventionInterface;
use JLM\DailyBundle\Model\FixingInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class FixingMailBuilder extends InterventionMailBuilder
{
	public function __construct(FixingInterface $fixing)
	{
		parent::__construct($fixing);
	}
	
	public function getFixing()
	{
		return $this->getIntervention();
	}
}