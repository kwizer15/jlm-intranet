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
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\Builder\VariantBillBuilder;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CoreBundle\Event\DoctrineEvent;
use JLM\CommerceBundle\Event\QuoteVariantEvent;
use JLM\FollowBundle\Entity\Thread;
use JLM\FollowBundle\Entity\StarterQuote;
use JLM\DailyBundle\Entity\Work;
use JLM\OfficeBundle\Entity\Order;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteVariantSubscriber implements EventSubscriberInterface
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
			JLMCommerceEvents::QUOTEVARIANT_GIVEN => 'createThread',
		);
	}
	
	public function createThread(QuoteVariantEvent $event)
	{		
		$entity = $event->getQuoteVariant();
		$starter = new StarterQuote($entity);
		$this->om->persist($starter);
		$thread = new Thread($starter);
		$this->om->persist($thread);
		$this->om->flush();
	}
}