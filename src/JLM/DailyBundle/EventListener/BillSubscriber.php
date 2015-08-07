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
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\CommerceBundle\Factory\BillFactory;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CoreBundle\Event\RequestEvent;
use JLM\DailyBundle\Builder\WorkBillBuilder;
use JLM\DailyBundle\Builder\InterventionBillBuilder;
use JLM\DailyBundle\Entity\Work;	// @todo Change to WorkInterface

use JLM\CoreBundle\Event\DoctrineEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillSubscriber implements EventSubscriberInterface
{	
	/**
	 * @var ObjectManager
	 */
	private $om;
	
	/**
	 * @var Request
	 */
	private $request;
	
	/**
	 * @param ObjectManager $om
	 * @param ContainerInterface $container
	 */
	public function __construct(ObjectManager $om, ContainerInterface $container)
	{
		$this->om = $om;
		$this->request = $container->get('request');
	}
	
	public static function getSubscribedEvents()
	{
		return array(
			//JLMCommerceEvents::BILL_FORM_POPULATE => 'populateFromIntervention',
				JLMCommerceEvents::BILLFORM_PRE_SET_DATA => 'onPreSetData',
			JLMCommerceEvents::BILL_AFTER_PERSIST => 'setBillToIntervention',
		);
	}
	
	public function onPreSetData(FormEvent $event)
	{
		if (null !== $interv = $this->getIntervention())
		{
			$builder = ($interv instanceof Work) ? (($interv->getQuote() !== null) ? new WorkBillBuilder($interv) : null) : null;
			$builder = ($builder === null) ? new InterventionBillBuilder($interv) : $builder;
			$entity = BillFactory::create($builder, $event->getData());
			$event->setData($entity);
			$event->getForm()->add('intervention', 'hidden', array('data' => $interv->getId(), 'mapped' => false));
		}
	}
	
	/**
	 * 
	 * @param FormPopulatingEvent $event
	 * @deprecated
	 */
	public function populateFromIntervention(FormPopulatingEvent $event)
	{
		if (null !== $interv = $this->getIntervention($event))
		{
			$builder = ($interv instanceof Work) ? (($interv->getQuote() !== null) ? new WorkBillBuilder($interv) : null) : null;
        	$builder = ($builder === null) ? new InterventionBillBuilder($interv) : $builder;
        	$entity = BillFactory::create($builder);
        	$event->getForm()->setData($entity);
			$event->getForm()->add('intervention', 'hidden', array('data' => $interv->getId(), 'mapped' => false));
		}
	}
	
	public function setBillToIntervention(DoctrineEvent $event)
	{
		if (null !== $entity = $this->getIntervention())
		{
			$om = $event->getObjectManager();
			$entity->setBill($event->getEntity());
			$om->persist($entity);
			$om->flush();
		}
	}
	
	private function getIntervention()
	{
		$id = $this->request->get('jlm_commerce_bill', array('intervention'=>$this->request->get('intervention')));
	
		return (isset($id['intervention']) && $id['intervention'] !== null) ? $this->om->getRepository('JLMDailyBundle:Intervention')->find($id['intervention']) : null;
	}
}