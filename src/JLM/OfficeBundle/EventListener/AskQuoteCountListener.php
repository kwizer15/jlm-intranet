<?php
namespace JLM\OfficeBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class AskQuoteCountListener
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

		$repo = $this->em->getRepository('JLMOfficeBundle:AskQuote');
		$response['layout']['askQuoteCount'] = array(
				'all' => $repo->getTotal(),
				'untreated' => $repo->getCountUntreated(),
				'treated' => $repo->getCountTreated(),
		);
		$response['today'] = new \DateTime;
		
		$event->setControllerResult($response);
	}
			
}