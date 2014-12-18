<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\DailyBundle\Entity\Fixing;
use JLM\DailyBundle\Form\Type\FixingType;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;

class DefaultController extends Controller
{
	/**
	 * Search
	 * @Route("/search", name="daily_search")
	 * @Method("get")
     * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function searchAction(Request $request)
	{
		$formData = $request->get('jlm_core_search');
    	 
    	if (is_array($formData) && array_key_exists('query', $formData))
    	{
    		$em = $this->getDoctrine()->getManager();
    		$entity = new Search();
    		$query = $formData['query'];
    		$entity->setQuery($query);
			$doors = $em->getRepository('JLMModelBundle:Door')->search($entity);
			/*
			 * Voir aussi
			* 	DoorController:stoppedAction
			* 	FixingController:newAction
			* @todo A factoriser de là ...
			*/
			$fixingForms = array();
			foreach ($doors as $door)
			{
				$form = new Fixing();
				$form->setDoor($door);
				$form->setAskDate(new \DateTime);
				$fixingForms[] = $this->get('form.factory')->createNamed('fixingNew'.$door->getId(),new FixingType(), $form)->createView();
			}
			/* à la */
			return array(
					'query'   => $entity->getQuery(),
					'doors'   => $doors,
					'fixing_forms' => $fixingForms,
			);
		}
		return array();
	}
	
	/**
	 * Search
	 * @Route("/search", name="daily_search_get")
	 * @Method("get")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function searchgetAction(Request $request)
	{
		return $this->redirect($this->generateUrl('intervention_today'));
	}
	
	/**
	 * Sidebar
	 * @Route("/sidebar", name="daily_sidebar")
     * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function sidebarAction()
	{
		$em = $this->getDoctrine()->getManager();
		return array(
		    'today' => $em->getRepository('JLMDailyBundle:Intervention')->getCountToday(),
			'stopped' => $em->getRepository('JLMModelBundle:Door')->getCountStopped(),
			'fixing' => $em->getRepository('JLMDailyBundle:Fixing')->getCountOpened(),
			'work'   => $em->getRepository('JLMDailyBundle:Work')->getCountOpened(),
			'maintenance' => $em->getRepository('JLMDailyBundle:Maintenance')->getCountOpened(),
		);
	}
	
	/**
	 * Search by date form
	 * @Route("/datesearch", name="daily_datesearch")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function datesearchAction()
	{
		$entity = new \DateTime();
		$form   = $this->createForm(new DatepickerType(), $entity);
		return array(
				'form' => $form->createView(),
		);
	}
	/**
	 * @Route("/", name="daily")
	 * @Template()
	 */
	public function indexAction()
	{
		return $this->redirect($this->generateUrl('intervention_today'));
	}
}
