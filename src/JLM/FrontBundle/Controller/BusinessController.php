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
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\NoResultException;

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

    	$service = (Kernel::MINOR_VERSION > 3) ? 'security.token_storage' : 'security.context';
    	$securityTokenStorage = $this->container->get($service);
    	
    	if (false === $securityTokenStorage->isGranted('ROLE_MANAGER'))
    	{
    		throw new AccessDeniedException();
    	}
    	
    	$om = $this->get('doctrine')->getManager();
    	$repoManager = $om->getRepository('JLMModelBundle:Trustee');
    	
    	try {
			$manager = $repoManager->getByUser($securityTokenStorage->getToken()->getUser());
    	} catch (NoResultException $e) {
    		if (false === $securityTokenStorage->isGranted('ROLE_ADMIN'))
    		{
    			throw new AccessDeniedException('Pas de contact lié à ce compte');
    		}
    		$manager = $repoManager->find(111); // Pour tests
    	}
		$repoSite = $om->getRepository('JLMModelBundle:Site');
		$sites = $repoSite->getByManager($manager);
		$activeBusinessId = sizeof($sites) ? $request->get('business', reset($sites)->getId()) : null;
		
		try {
			$activeBusiness = $repoSite->find($activeBusinessId);
			if (!$activeBusiness->hasContractWith($manager))
			{
				$activeBusinessId = sizeof($sites) ? reset($sites)->getId() : null;
				$activeBusiness = $repoSite->find($activeBusinessId);
			}
			// Vérifier si l'affaire fait partie du syndic
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
