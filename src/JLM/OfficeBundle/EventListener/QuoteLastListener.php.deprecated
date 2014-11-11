<?php
namespace JLM\OfficeBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class QuoteLastListener
{	
	private $em;
	
	public function __construct($em)
	{
		$this->em = $em;
	}
	
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