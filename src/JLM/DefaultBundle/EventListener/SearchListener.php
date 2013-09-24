<?php
namespace JLM\DefaultBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;

class SearchListener
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

		if (!isset($response['layout']['form_search_query']))
			$entity = new Search;
		else
		{
			$entity = $response['layout']['form_search_query'];
			unset($response['layout']['form_search_query']);
		}
		$form   = $this->formService->create(new SearchType(), $entity);
		//echo get_class($this->form); exit;
		$response['layout']['form_search'] = $form->createView();

		$event->setControllerResult($response);
	}
		
}