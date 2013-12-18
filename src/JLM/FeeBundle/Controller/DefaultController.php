<?php

namespace JLM\FeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\FeeBundle\Entity\FeesFollower;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    
    /**
     * @Route("/generate")
     */
    public function generateAction(FeesFollower $follower)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	// On prend toutes les redevances
    	$fees = $em->getRepository('JLMFeeBundle:Fee')->findAll();
    	
    	// On genère les factures
    	foreach ($fees as $fee)
    	{
    		$bill = $fee->createBill($follower, new Bill);
    	}
    		
    }
}
