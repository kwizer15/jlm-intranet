<?php

/*
 * This file is part of the JLMFrontBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BusinessController extends Controller
{   
	public function tabAction()
	{
		
	}
	
    public function listAction()
    {
    	//return $this->render('JLMFrontBundle:Business:list.html.twig', array());
    	$request = $this->get('request');
    	
    	$om = $this->get('doctrine')->getManager();
		$manager = $om->getRepository('JLMModelBundle:Trustee')->find(111);
		
		$repo = $om->getRepository('JLMModelBundle:Site');
		$sites = $repo->getByManager($manager);
		$activeBusinessId = sizeof($sites) ? $request->get('business', reset($sites)->getId()) : null;
		try {
			$activeBusiness = $repo->find($activeBusinessId);
		} catch (\Doctrine\ORM\NoResultException $e) {
			throw $this->createNotFoundException('Cette affaire n\'existe pas');
		}
		
		// Filtre pour les contrats actuels
		$doors = $activeBusiness->getDoors();
		$businessDoors    = [];
		$lastsMaintenance = [];
		$lastsFixing      = [];
		$askQuoteForms    = [];
		$qs = array();
		foreach ($doors as $key => $door)
		{
			$contract = $door->getActualContract();
			if ($contract !== null && $contract->getTrustee() == $manager)
			{
				$businessDoors[] = $door;
				$lastsMaintenance[] = $om->getRepository('JLMDailyBundle:Maintenance')->getLastsByDoor($door, 2);
				$lastsFixing[] = $om->getRepository('JLMDailyBundle:Fixing')->getLastsByDoor($door, 2);
				$quotes = $om->getRepository('JLMCommerceBundle:Quote')->getSendedByDoor($door);
				$askQuoteForms[] = [];
				foreach ($quotes as $quote)
				{
					$form = $this->createAskQuoteForm();
					$form->get('quoteNumber')->setData($quote->getNumber());
					$askQuoteForms[$key][] = $form->createView();
				}
				$qs[] = $quotes;
			}
			
		}
		
    	return $this->render('JLMFrontBundle:Business:list.html.twig', array(
    			'manager' => $manager,
    			'businesses' => $sites,
    			'activeBusiness' => $activeBusiness,
    			'doors' => $businessDoors,
    			'lastsMaintenance' => $lastsMaintenance,
    			'lastsFixing' => $lastsFixing,
    			'quotes' => $qs,
    			'askQuoteForms' => $askQuoteForms,
    	));
    }
    
    public function askquoteAction()
    {
    	$request = $this->getRequest();
    	$form = $this->createAskQuoteForm();
    	$form->handleRequest($request);
    
    	if ($form->isValid())
    	{
    		$this->container->get('jlm_front.mailer')->sendAskQuoteEmailMessage($form->getData());
    		$this->container->get('jlm_front.mailer')->sendConfirmAskQuoteEmailMessage($form->getData());
    		
    		return new JsonResponse(array('success' => true));
    	}
    	 
    	return new JsonResponse(array('success' => false));
    }
    
    private function createAskQuoteForm()
    {
    	$form = $this->createForm('jlm_front_askquotetype', null, array(
	    	'action' => $this->generateUrl('jlm_front_business_askquote'),
	    	'method' => 'POST',
    	));
    	$form->add('submit','submit');
    	
    	return $form;
    }
}
