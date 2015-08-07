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
use JLM\CoreBundle\Event\DoctrineEvent;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
			JLMCommerceEvents::BILL_BOOST_SENDMAIL => 'persistEmails',
		);
	}
	
	/**
	 * @param FormEvent $event
	 */
	public function onPreSetData(FormEvent $event)
	{
		if (null !== $variant = $this->getQuoteVariant())
		{
			$entity = BillFactory::create(new VariantBillBuilder($variant, $event->getData()));
        	$event->setData($entity);
        	$event->getForm()->add('variant', 'hidden', array('data' => $interv->getId(), 'mapped' => false));
		}
	}
	
	/**
	 * @param BillEvent $event
	 */
	public function persistEmails(BillEvent $event)
	{
		$bill = $event->getBill();
		$src = $bill->getSrc();
		$mail = $event->getParam('jlm_core_mail');
		$to = (isset($mail['to'])) ? $mail['to'] : array();
		$cc = (isset($mail['cc'])) ? $mail['cc'] : array();
		/**
		 * Truc archaique pour sauver les adresses depuis la source
		 */
		if (method_exists($src,'setAccountingEmails'))
		{
			$src->setAccountingEmails($to);
		}
		if (method_exists($src,'setManagerEmails'))
		{
			$src->setManagerEmails($cc);
		}
		if ($src !== null)
		{
			$this->om->persist($src);
			$this->om->flush();
		}
	}
	
	/**
	 * @return NULL | QuoteVariant
	 */
	private function getQuoteVariant()
	{
		$id = $this->request->get('jlm_commerce_bill', array('variant'=>$this->request->get('variant')));
	
		return (isset($id['variant']) && $id['variant'] !== null) ? $this->om->getRepository('JLMCommerceBundle:QuoteVariant')->find($id['variant']) : null;
	}
}