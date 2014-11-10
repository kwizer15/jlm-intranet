<?php
namespace JLM\OfficeBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class BillCountListener
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