<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CoreBundle\Event\DoctrineEvent;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use JLM\TransmitterBundle\Builder\AttributionBillBuilder;

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
	
	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return array(
			JLMCommerceEvents::BILLFORM_PRE_SET_DATA => 'onPreSetData',
			JLMCommerceEvents::BILL_POSTPERSIST => 'setBillToAttribution',
		);
	}
	
	/**
	 * @param FormEvent $event
	 */
	public function onPreSetData(FormEvent $event)
	{
		if (null !== $attribution = $this->getAttribution($event))
		{
			$options = array(
					'port' => $this->om->getRepository('JLMProductBundle:Product')->find(134),
			);
			$vat = $this->om->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate();
			$entity = BillFactory::create(new AttributionBillBuilder($attribution, $vat, $options), $event->getData());
        	$event->setData($entity);
        	$event->getForm()->add('attribution', 'hidden', array('data' => $attribution->getId(), 'mapped' => false));
		}
	}
	
	/**
	 * @param DoctrineEvent $event
	 */
	public function setBillToAttribution(DoctrineEvent $event)
	{
		if (null !== $entity = $this->getAttribution($event))
		{
			$om = $event->getObjectManager();
			$entity->setBill($event->getEntity());
			$om->persist($entity);
			$om->flush();
		}
	}
	
	/**
	 * @return NULL | Attribution
	 */
	private function getAttribution()
	{
		$id = $this->request->get('jlm_commerce_bill', array('attribution'=>$this->request->get('attribution')));
		
		return (isset($id['attribution']) && $id['attribution'] !== null) ? $this->om->getRepository('JLMTransmitterBundle:Attribution')->find($id['attribution']) : null;
	}
}