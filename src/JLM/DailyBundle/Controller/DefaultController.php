<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Form\Type\DatepickerType;

class DefaultController extends Controller
{
	/**
	 * Search
	 * @Route("/search", name="daily_search")
	 * @Method("post")
     * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function searchAction(Request $request)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$query = $request->request->get('query');
		$doors = $em->getRepository('JLMModelBundle:Door')->search($query);
		return array(
			'query'   => $query,
			'doors'   => $doors,
		);
	}
	
	/**
	 * Sidebar
	 * @Route("/sidebar", name="daily_sidebar")
     * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function sidebarAction()
	{
		$em = $this->getDoctrine()->getEntityManager();

		$entity = new \DateTime();
		$form   = $this->createForm(new DatepickerType(), $entity);
		
		$now = new \DateTime;
		$today = \DateTime::createFromFormat('YmdHis',$now->format('Ymd').'000000');
		$tommorow = \DateTime::createFromFormat('YmdHis',$now->format('Ymd').'235959');
		return array(
			'form' => $form->createView(),
		    'today' => $em->getRepository('JLMDailyBundle:Intervention')->getCountWithDate($today,$tommorow),
			'stopped' => 0,
			'fixing' => $em->getRepository('JLMDailyBundle:Fixing')->getCountOpened(),
			'work'   => $em->getRepository('JLMDailyBundle:Work')->getCountOpened(),
			'maintenance' => $em->getRepository('JLMDailyBundle:Maintenance')->getCountOpened(),
		);
	}
	
	/**
	 * @Route("/", name="daily")
	 * @Template()
	 */
	public function indexAction()
	{
		return array();
	}
	
    /**
     * @Route("/a", name="daily_a")
     * @Template()
     */
    public function aAction()
    {
        return array();
    }
    
    /**
     * @Route("/b", name="daily_b")
     * @Template()
     */
    public function bAction()
    {
    	return array();
    }
    
    /**
     * @Route("/c", name="daily_c")
     * @Template()
     */
    public function cAction()
    {
    	return array();
    }
}
