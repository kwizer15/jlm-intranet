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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\Builder\VariantBillBuilder;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\CommerceBundle\Entity\BillBoost;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillBoostSubscriber implements EventSubscriberInterface
{	
	const BOOSTMETHOD_COURRIER = 1;
	const BOOSTMETHOD_EMAIL = 2;
	
	private $om;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public static function getSubscribedEvents()
	{
		return array(
			JLMCommerceEvents::BILL_BOOST => 'persistBoostCourrier',
			JLMCommerceEvents::BILL_BOOST_EMAIL => 'persistBoostEmail',
		);
	}
	
	public function persistBoostCourrier(BillEvent $event)
	{
		$this->_peristsBoost($event, self::BOOSTMETHOD_COURRIER);
	}
	
	public function persistBoostEmail(BillEvent $event)
	{
		$this->_peristsBoost($event, self::BOOSTMETHOD_EMAIL);
	}
	
	protected function _peristsBoost(BillEvent $event, $methodId)
	{
		$bill = $event->getBill();
		$date = new \DateTime;
		$method = $this->om->getRepository('JLMCommerce:BoostMethod')->find($methodId);
		$boost = new BillBoost();
		$boost->setBill($bill)->setDate($date)->setMethod($method);
		
		$this->om->persist($boost);
		$this->om->flush();
	}
}