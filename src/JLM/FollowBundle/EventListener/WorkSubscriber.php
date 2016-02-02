<?php

/*
 * This file is part of the JLMFollowBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FollowBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\DailyBundle\JLMDailyEvents;
use JLM\CoreBundle\Event\DoctrineEvent;
use JLM\OfficeBundle\JLMOfficeEvents;


/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class WorkSubscriber implements EventSubscriberInterface
{	
	/**
	 * @var ObjectManager
	 */
	private $om;
	
	/**
	 * Constructor
	 * @param ObjectManager $om
	 */
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			JLMDailyEvents::WORK_POSTPERSIST => 'updateThread',
			JLMDailyEvents::WORK_POSTUPDATE => 'updateThread',
		);
	}
	
	/**
	 * Update thread since work update
	 * @param InterventionEvent $event
	 */
	public function updateThread(DoctrineEvent $event)
	{
		$entity = $event->getEntity();
		$thread = $this->om->getRepository('JLMFollowBundle:Thread')->getByWork($entity);
		$thread->getState();
		$this->om->persist($thread);
		$this->om->flush();
	}
}