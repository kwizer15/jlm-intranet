<?php
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

class DoctrineSubscriber implements EventSubscriber
{	
	private $dispatcher;
	
	public function __construct(EventDispatcherInterface $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}
	
	public function dispatch($eventName, LifecycleEventArgs $args)
	{
		$this->dispatcher->dispatch($this->getSymfonyEventName($args).'_'.$eventName, new DoctrineEvent($args->getEntity()));
	}
	
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

    public function getSymfonyEventName(LifecycleEventArgs $args)
    {
    	$entity = $args->getEntity();
    	$class = get_class($entity);
    	$class = strtolower($class);
    	$class = str_replace('bundle\\entity\\', '.', $class);
    	$class = str_replace('\\', '_', $class);
    
    	return $class;
    }

    public function preRemove(LifecycleEventArgs $args)
    {
    	return $this->dispatch('preremove', $args);
    }
    
    public function postRemove(LifecycleEventArgs $args)
    {
    	return $this->dispatch('postremove', $args);
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
    	return $this->dispatch('prepersist', $args);
    }
    
    public function postPersist(LifecycleEventArgs $args)
    {
    	return $this->dispatch('postpersist', $args);
    }
    
    public function preUpdate(LifecycleEventArgs $args)
    {
    	return $this->dispatch('preupdate', $args);
    }
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        return $this->dispatch('postupdate', $args);
    }
    
    public function postLoad(LifecycleEventArgs $args)
    {
        return $this->dispatch('postload', $args);
    }
    
    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        // return $this->dispatch('loadclassmetadata', $args);
    }
    
    public function onClassMetadataNotFound(LifecycleEventArgs $args)
    {
        return $this->dispatch('onclassmetadatanotfound', $args);
    }
    
    public function preFlush(PreFlushEventArgs $args)
    {
        // return $this->dispatch('preflush', $args);
    }
    
    public function onFlush(OnFlushEventArgs $args)
    {
        // return $this->dispatch('onflush', $args);
    }
    
    public function postFlush(PostFlushEventArgs $args)
    {
        // return $this->dispatch('postflush', $args);
    }
    
    public function onClear(OnClearEventArgs $args)
    {
        // return $this->dispatch('onclear', $args);
    }
}