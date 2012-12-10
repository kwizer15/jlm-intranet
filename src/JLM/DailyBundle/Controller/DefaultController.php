<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

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
