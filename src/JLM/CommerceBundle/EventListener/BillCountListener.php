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
class BillCountListener
{	
    /**
     * @var EntityManager
     */
	private $em;
	
	/**
	 * Constructor
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

		$repo = $this->em->getRepository('JLMCommerceBundle:Bill');
		$response['layout']['billCount'] = array(
    			'todo' => $this->em->getRepository('JLMDailyBundle:Intervention')->getCountToBilled(),
    			'all' => $repo->getTotal(),
    			'input' => $repo->getCount(0),
    			'send' => $repo->getCount(1),
    			'payed' => $repo->getCount(2),
    			'canceled' => $repo->getCount(-1),
    	);
		
		$event->setControllerResult($response);
	}
			
}