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
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;


/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ShiftTechnicianSubscriber implements EventSubscriberInterface
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
			JLMDailyEvents::SHIFTTECHNICIAN_POSTPERSIST => 'updateThread',
			JLMDailyEvents::SHIFTTECHNICIAN_POSTREMOVE => 'updateThread',
		);
	}
	
	/**
	 * Update thread since work update
	 * @param InterventionEvent $event
	 */
	public function updateThread(DoctrineEvent $event)
	{
		if ($thread = $this->__getThread($event))
		{
			$thread->getState();
			$this->om->persist($thread);
			$this->om->flush();
		}
	}
	
	/**
	 * 
	 * @param DoctrineEvent $event
	 * @return mixed|NULL
	 */
	private function __getThread(DoctrineEvent $event)
	{
		try {
			return $this->om->getRepository('JLMFollowBundle:Thread')->getByShiftTechnician($event->getEntity());
		} catch (NoResultException $e) {
			return null;
		} catch (NonUniqueResultException $e) {
			return null;
		}
	}
}