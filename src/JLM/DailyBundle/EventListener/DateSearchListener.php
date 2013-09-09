<?php
namespace JLM\DailyBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use JLM\ModelBundle\Form\Type\DatepickerType;

class DateSearchListener
{	
	private $formService;
	
	public function __construct($formService)
	{
		$this->formService = $formService;
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
		
		if (!isset($response['layout']['form_searchByDate_date']))
			$entity = new \DateTime();
		else 
		{
			$entity = $response['layout']['form_searchByDate_date'];
			unset($response['layout']['form_searchByDate_date']);
		}
		$form   = $this->formService->create(new DatepickerType(), $entity);
		//echo get_class($this->form); exit;
		$response['layout']['form_searchByDate'] = $form->createView();
		
		$event->setControllerResult($response);
	}
			
}