<?php

namespace JLM\FollowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\FeeBundle\Entity\FeesFollower;
use JLM\FeeBundle\Entity\Fee;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contract controller.
 */
class DefaultController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
    	$page = $request->get('page',1);
    	$resultsByPage = $request->get('resultsByPage',10);
    	$route_params = array();
    	if ($resultsByPage != 10)
    	{
    		$route_params['resultsByPage'] = $resultsByPage;
    	}

    	$threads = $this->getDoctrine()->getManager()->getRepository('JLMFollowBundle:Thread')->getThreads($page, $resultsByPage);

    	$pagination = array(
            'page' => $page,
            'route' => 'jlm_follow_default_index',
            'pages_count' => ceil(count($threads) / $resultsByPage),
            'route_params' => $route_params,
        );
   	
        return array(
        	'threads' => $threads,
        	'pagination' => $pagination,
        );
    }
    
    /**
     * @Template()
     */
    public function quoteAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$threads = $em->getRepository('JLMFollowBundle:Thread')->findBy(array(),array('startDate'=>'DESC'));
    	return array('threads' => $threads);
    }
    
    /**
     * @Template()
     */
    public function interventionAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$threads = $em->getRepository('JLMFollowBundle:Thread')->findBy(array(),array('startDate'=>'DESC'));
    	return array('threads' => $threads);
    }
}
