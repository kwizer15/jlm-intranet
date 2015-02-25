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
//    	$state = array('unclosed'=>'getUnclosed');
    	$em = $this->getDoctrine()->getManager();
    	$threads = $em->getRepository('JLMFollowBundle:Thread')->findBy(array(),array('startDate'=>'DESC'));
        return array('threads' => $threads);
    }
}
