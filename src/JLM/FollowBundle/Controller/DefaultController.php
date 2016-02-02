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
    	$defaultResultsByPage = 10;
    	
    	$page = $request->get('page',1);
    	$resultsByPage = $request->get('resultsByPage', $defaultResultsByPage);
    	$route_params = [];
    	foreach (array('type', 'sort', 'state') as $param)
    	{
    		if ($value = $request->get($param, null))
    		{
    			$route_params[$param] = $value;
    		}
    	}
    	$threads = $this->getDoctrine()->getManager()->getRepository('JLMFollowBundle:Thread')->getThreads($page, $resultsByPage, $route_params);

    	if ($resultsByPage != $defaultResultsByPage)
    	{
    		$route_params['resultsByPage'] = $resultsByPage;
    	}
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
    
    public function updateAction()
    {
    	$om = $this->getDoctrine()->getManager();
    	$threads = $this->getDoctrine()->getManager()->getRepository('JLMFollowBundle:Thread')->findAll();
    	foreach ($threads as $thread)
    	{
    		$thread->getState();
    		$thread->getAmount();
    		$om->persist($thread);
    	}
    	
    	$om->flush();
    	
    	return 'Mise à jour OK';
    }
}
