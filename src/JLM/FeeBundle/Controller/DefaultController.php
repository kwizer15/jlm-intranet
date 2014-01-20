<?php

namespace JLM\FeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\FeeBundle\Entity\FeesFollower;
use JLM\FeeBundle\Entity\Fee;

/**
 * Contract controller.
 *
 * @Route("/feedefault")
 */
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
     * Action temporaire
     * 
     * Création à la volée des redevances
     * 
     * @Route("/autocreate")
     * @Template()
     */
    public function autocreatefeeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$contracts = $em->getRepository('JLMModelBundle:Contract')->findAll();
    	
    	foreach ($contracts as $contract)
    	{
    		if ($contract->getInProgress())
    		{
    			$fee = new Fee();
    			$fee->addContract($contract);
    			$fee->setTrustee($contract->getTrustee());
    			$fee->setAddress($contract->getDoor()->getSite()->getAddress()->toString());
    			$fee->setPrelabel($contract->getDoor()->getSite()->getBillingPrelabel());
    			$fee->setVat($contract->getDoor()->getSite()->getVat());
    			$em->persist($fee);
    		}
    	}
    	$em->flush();
    	return array();
    }
}
