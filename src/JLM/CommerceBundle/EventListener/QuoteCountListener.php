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

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernel;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteCountListener
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
		{
			return;
		}
	
		$response = $event->getControllerResult();
		if (!is_array($response))
		{
			return;
		}
		
		if (!isset($response['layout']))
		{
			$response['layout'] = array();
		}

		$date = new \DateTime;
		$year = $date->format('Y');
		$repo = $this->em->getRepository('JLMCommerceBundle:Quote');
		$response['layout']['quoteCount'] = array(
				'all' => $repo->getCountState('uncanceled', $year),
				'input' => $repo->getCountState(0, $year),
				'wait' => $repo->getCountState(1, $year),
				'send' => $repo->getCountState(3, $year),
				'given' => $repo->getCountState(5, $year),
		);
		
		$event->setControllerResult($response);
	}
			
}