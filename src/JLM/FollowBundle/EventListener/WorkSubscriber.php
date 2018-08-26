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
        return [
            JLMDailyEvents::WORK_PREREMOVE => 'removeThread',
            JLMDailyEvents::WORK_POSTUPDATE => 'updateThread',
        ];
    }
    
    /**
     * Update thread since work update
     * @param InterventionEvent $event
     */
    public function updateThread(DoctrineEvent $event)
    {
        if ($thread = $this->__getThread($event)) {
            $thread->getState();
            $this->om->persist($thread);
            $this->om->flush();
        }
    }
    
    /**
     * Update thread since work update
     * @param InterventionEvent $event
     */
    public function removeThread(DoctrineEvent $event)
    {
        $thread = $this->__getThread($event);
        if ($thread) {
            if ($thread->getStarter() !== null) {
                $this->om->remove($thread->getStarter());
            }
            $this->om->remove($thread);
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
            return $this->om->getRepository('JLMFollowBundle:Thread')->getByWork($event->getEntity());
        } catch (NoResultException $e) {
            return null;
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
