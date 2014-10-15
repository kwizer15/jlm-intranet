<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;

class DefaultController extends Controller
{
    /**
     * Resultats de la barre de recherche.
     *
     * @Route("/search", name="model_search")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function searchAction(Request $request)
    {
    	$entity = new Search;
    	$form = $this->createForm(new SearchType(), $entity);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
    		return array(
    				'layout'=>array('form_search_query'=>$entity),
    				'query'   => $entity->getQuery(),
    				'doors'   => $em->getRepository('JLMModelBundle:Door')->search($entity),
    				'sites'   => $em->getRepository('JLMModelBundle:Site')->search($entity),
    				'trustees'=> $em->getRepository('JLMModelBundle:Trustee')->search($entity),
    				'suppliers'=> $em->getRepository('JLMModelBundle:Supplier')->search($entity),
    				'products' => $em->getRepository('JLMProductBundle:Product')->search($entity),
    				'persons' => $em->getRepository('JLMModelBundle:Person')->search($entity),
    		);
    	}
    	return array(
    			'layout'=>array('form_search_query'=>$entity->getQuery()),
    			'query' => $entity->getQuery(),
    	);
    }
    
    /**
     * Upgrade contacts
     * 
     * @Route("/upgrade", name="model_upgrade")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function upgradeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repo = $em->getRepository('JLMModelBundle:SiteContact');
    	$contacts = $repo->findAll();
    	foreach ($contacts as $contact)
    	{
    		$role = $contact->getOldRole();
    		$person = $contact->getPerson();
    		$person->setRole($role);
    		$em->persist($person);
    	}
    	$quotes = $em->getRepository('JLMOfficeBundle:Quote')->findAll();
    	foreach ($quotes as $quote)
    	{
    		$contact = $quote->getContact();
    		if ($contact !== null)
    			$quote->setContactPerson($contact->getPerson());
    		$em->persist($quote);
    	}
    	$em->flush();
    	return array();
    }
}
