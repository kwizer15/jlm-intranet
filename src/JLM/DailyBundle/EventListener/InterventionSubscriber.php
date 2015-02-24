<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\DailyBundle\JLMDailyEvents;
use JLM\DailyBundle\Builder\InterventionWorkBuilder;
use JLM\DailyBundle\Event\InterventionEvent;
use JLM\DailyBundle\Factory\WorkFactory;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class InterventionSubscriber implements EventSubscriberInterface
{	
	private $om;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public static function getSubscribedEvents()
	{
		return array(
			JLMDailyEvents::INTERVENTION_SCHEDULEWORK => 'createWork',
		);
	}
	
	public function createWork(InterventionEvent $event)
	{
		$interv = $event->getIntervention();
		$options = array(
				'category' => $this->om->getRepository('JLMDailyBundle:WorkCategory')->find(1),
				'objective' => $this->om->getRepository('JLMDailyBundle:WorkObjective')->find(1),
		);
		$work = WorkFactory::create(new InterventionWorkBuilder($interv, $options));
		$this->om->persist($work);
		$interv->setWork($work);
		$this->om->persist($interv);
		$this->om->flush();
	}
}