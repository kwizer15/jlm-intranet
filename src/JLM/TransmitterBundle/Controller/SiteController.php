<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;
use JLM\ModelBundle\Entity\Site;

/**
 * Site controller.
 *
 * @Route("/site")
 */
class SiteController extends Controller
{
    /**
     * @Route("/{id}/show",name="transmitter_site_show")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function showAction(Site $entity)
    {
        return array('entity'=>$entity);
    }
    
    /**
     * @Route("/{id}/printlist",name="transmitter_site_printlist")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function printlistAction(Site $entity)
    {
    	$em = $this->getDoctrine()->getManager();
   
    	// Retrier les bips par Groupe puis par numéro
    	$transmitters = $em->getRepository('JLMTransmitterBundle:Transmitter')->getFromSite($entity->getId())->getQuery()->getResult();
    	
    	$resort = array();
    	foreach ($transmitters as $transmitter)
    	{
    		$index = $transmitter->getUserGroup()->getName();
    		if (!isset($resort[$index]))
    			$resort[$index] = array();
    		$resort[$index][] = $transmitter;
    	}
    	$final = array();
    	foreach ($resort as $list)
    		$final = array_merge($final,$list);
    	unset($resort);
    
    
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename=liste-'.$entity->getId().'.pdf');
    	$response->setContent($this->render('JLMTransmitterBundle:Site:printlist.pdf.php',
    			array(
    					'entity' => $entity,
    					'transmitters' => $final,
    					'withHeader' => true,
    			)));
    
    	return $response;
    }
}
