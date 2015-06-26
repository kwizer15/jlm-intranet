<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use JLM\CoreBundle\Event\DoctrineEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\Common\Persistence\Event\OnClearEventArgs;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DoctrineSubscriber implements EventSubscriber
{	
	/**
	 * @var EventDispatcherInterface
	 */
	private $dispatcher;
	
	/**
	 * Constructor
	 * @param EventDispatcherInterface $dispatcher
	 */
	public function __construct(EventDispatcherInterface $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}
	
	/**
	 * Dispatch an event
	 * @param string $eventName
	 * @param LifecycleEventArgs $args
	 */
	public function dispatch($eventName, LifecycleEventArgs $args)
	{
		$this->dispatcher->dispatch($this->getSymfonyEventName($args).'_'.$eventName, new DoctrineEvent($args->getEntity(), $args->getEntityManager()));
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSubscribedEvents()
    {
        return array(
        	'preRemove',
        	'postRemove',
        	'prePersist',
            'postPersist',
        	'preUpdate',
            'postUpdate',
        	'postLoad',
//        	'loadClassMetadata',
//        	'onClassMetadataNotFound',
//        	'preFlush',
//        	'onFlush',
//        	'postFlush',
//        	'onClear'
        );
    }

    /**
     * Convert entity classname into eventname
     * @param LifecycleEventArgs $args
     * @return string
     */
    public function getSymfonyEventName(LifecycleEventArgs $args)
    {
    	$entity = $args->getEntity();
    	$class = get_class($entity);
    	$class = strtolower($class);
    	$class = str_replace('bundle\\entity\\', '.', $class);
    	$class = str_replace('\\', '_', $class);
    
    	return $class;
    }

    /**
     * Re-dispatch the doctrine preRemove event
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
    	return $this->dispatch('preremove', $args);
    }
    
    /**
     * Re-dispatch the doctrine postRemove event
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
    	return $this->dispatch('postremove', $args);
    }
    
    /**
     * Re-dispatch the doctrine prePersist event
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
    	return $this->dispatch('prepersist', $args);
    }
    
    /**
     * Re-dispatch the doctrine postPersist event
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
    	return $this->dispatch('postpersist', $args);
    }
    
    /**
     * Re-dispatch the doctrine preUpdate event
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
    	return $this->dispatch('preupdate', $args);
    }
    
    /**
     * Re-dispatch the doctrine postUpdate event
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        return $this->dispatch('postupdate', $args);
    }
    
    /**
     * Re-dispatch the doctrine postLoad event
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        return $this->dispatch('postload', $args);
    }
    
    /**
     * Re-dispatch the doctrine loadClassMetadata event
     * @param LifecycleEventArgs $args
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        // return $this->dispatch('loadclassmetadata', $args);
    }
    
    /**
     * Re-dispatch the doctrine onClassMetadataNotFound event
     * @param LifecycleEventArgs $args
     */
    public function onClassMetadataNotFound(LifecycleEventArgs $args)
    {
        return $this->dispatch('onclassmetadatanotfound', $args);
    }
    
    /**
     * Re-dispatch the doctrine preFlush event
     * @param LifecycleEventArgs $args
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        // return $this->dispatch('preflush', $args);
    }
    
    /**
     * Re-dispatch the doctrine onFlush event
     * @param LifecycleEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        // return $this->dispatch('onflush', $args);
    }
    
    /**
     * Re-dispatch the doctrine postFlush event
     * @param LifecycleEventArgs $args
     */
    public function postFlush(PostFlushEventArgs $args)
    {
        // return $this->dispatch('postflush', $args);
    }
    
    /**
     * Re-dispatch the doctrine onClear event
     * @param LifecycleEventArgs $args
     */
    public function onClear(OnClearEventArgs $args)
    {
        // return $this->dispatch('onclear', $args);
    }
}