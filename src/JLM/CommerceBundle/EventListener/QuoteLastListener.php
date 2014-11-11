<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernel;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteLastListener
{	
	/**
	 * @var EntityManager $em
	 */
	private $em;
	
	/**
	 * @param EntityManager $em
	 */
	public function __construct($em)
	{
		$this->em = $em;
	}
	
	/**
	 * @param GetResponseForControllerResultEvent $event
	 */
	public function onKernelResponse(GetResponseForControllerResultEvent $event)
	{
		if (HttpKernel::MASTER_REQUEST != $event->getRequestType())
			return;
	
		$response = $event->getControllerResult();
		if (!is_array($response))
			return;
		
		if (!isset($response['layout']))
			$response['layout'] = array();

		$repo = $this->em->getRepository('JLMOfficeBundle:Quote');
		$response['layout']['quoteLast'] = $repo->findBy(
				array(),
				array('number'=>'desc'),
				5
		);

		$event->setControllerResult($response);
	}
			
}