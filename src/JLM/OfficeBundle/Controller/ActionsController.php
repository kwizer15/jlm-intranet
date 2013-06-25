<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;


/**
 * Actions controller.
 *
 * @Route("/actions")
 */
class ActionsController extends Controller
{
	/**
	 * @Route("/bill/list", name="actions_billlist")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function billlistAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$list = $em->getRepository('JLMDailyBundle:Intervention')->getToBilled();
		return array('entities'=>$list);
	}
	
	/**
	 * @Route("/contact/list", name="actions_contactlist")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function contactlistAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$list = $em->getRepository('JLMDailyBundle:Intervention')->getToContact();
		return array('entities'=>$list);
	}
}