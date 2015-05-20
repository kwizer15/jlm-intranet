<?php

namespace JLM\FollowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\FeeBundle\Entity\FeesFollower;
use JLM\FeeBundle\Entity\Fee;

/**
 * Contract controller.
 */
class DefaultController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
//    	$date = new \DateTime;
//    	$request = $this->getRequest();
//    	$month = $request->get('month',$date->format('n'));
//    	$year = $request->get('year',$date->format('Y'));
//    	$begin = \DateTime::createFromFormat('d/n/Y H:i:s','01/'.$month.'/'.$year.' 00:00:00');
//    	$end = \DateTime::createFromFormat('d/n/Y H:i:s',$begin->format('').'/'.$month.'/'.$year.' 00:00:00');
//    	$state = array('unclosed'=>'getUnclosed');
    	$em = $this->getDoctrine()->getManager();
    	$threads = $em->getRepository('JLMFollowBundle:Thread')->findBy(array(),array('startDate'=>'DESC'));
        return array('threads' => $threads);
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
