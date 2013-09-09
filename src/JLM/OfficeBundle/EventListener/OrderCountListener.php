<?php
namespace JLM\OfficeBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class OrderCountListener
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

		$repo = $this->em->getRepository('JLMOfficeBundle:Order');
		$response['layout']['orderCount'] = array(
				'todo' => $this->em->getRepository('JLMDailyBundle:Work')->getCountOrderTodo(),
				'all' => $repo->getTotal(),
				'input' => $repo->getCount(0),
				'ordered' => $repo->getCount(1),
				'ready' => $repo->getCount(2),
		);
		
		$event->setControllerResult($response);
	}
			
}