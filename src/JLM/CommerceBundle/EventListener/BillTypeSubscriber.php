<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use JLM\CommerceBundle\Entity\BillLine;
use JLM\CommerceBundle\Entity\Bill;
use JLM\CommerceBundle\JLMCommerceEvents;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillTypeSubscriber implements EventSubscriberInterface
{	
	/**
	 * @var ObjectManager
	 */
	private $om;
	
	/**
	 * @var EventDispatcherInterface
	 */
	private $dispatcher;
	
	/**
	 * @param ObjectManager $om
	 * @param EventDispatcherInterface $dispatcher
	 */
	public function __construct(ObjectManager $om, EventDispatcherInterface $dispatcher)
	{
		$this->$om = $om;
		$this->dispatcher = $dispatcher;
	}
	
	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return array(
			FormEvents::PRE_SET_DATA => 'onPreSetData',
		);
	}
	
	/**
	 * @param FormEvent $event
	 */
	public function onPreSetData(FormEvent $event)
	{
		$bill = $event->getData();
		$bill = ($bill === null) ? new Bill() : $bill;
		$vat = $this->om->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate();
		$bill
			->setCreation(new \DateTime)
			->setVat($vat)
			->setVatTransmitter($vat)
			->setPenalty((string)$this->om->getRepository('JLMCommerceBundle:PenaltyModel')->find(1))
			->setProperty((string)$this->om->getRepository('JLMCommerceBundle:PropertyModel')->find(1))
			->setEarlyPayment((string)$this->om->getRepository('JLMCommerceBundle:EarlyPaymentModel')->find(1))
			->setMaturity(30)
			->setDiscount(0)
		;

		$event->setData($bill);
		
		$this->dispatcher->dispatch(JLMCommerceEvents::BILLFORM_PRE_SET_DATA, $event);
		
		// On met une ligne s'il n'y en a pas
		if (!sizeof($event->getData()->getLines()))
		{
			$event->getData()->addLine(new BillLine());
		}
	}
}