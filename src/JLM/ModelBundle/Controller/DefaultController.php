<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\CoreBundle\Entity\Search;
use JLM\CoreBundle\Form\Type\SearchType;

class DefaultController extends Controller
{
    /**
     * Resultats de la barre de recherche.
     *
     * @Route("/search", name="model_search")
     * @Method("get")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function searchAction(Request $request)
    {
    	$formData = $request->get('jlm_core_search');

    	if (is_array($formData) && array_key_exists('query', $formData))
    	{
    		$em = $this->getDoctrine()->getManager();
    		$entity = new Search();
    		$query = $formData['query'];
    		$entity->setQuery($query);
    		return array(
    				'query' => $query,
    				'doors'   => $em->getRepository('JLMModelBundle:Door')->search($entity),
    				'sites'   => $em->getRepository('JLMModelBundle:Site')->search($entity),
    				'trustees'=> $em->getRepository('JLMModelBundle:Trustee')->search($entity),
    				'suppliers'=> $em->getRepository('JLMProductBundle:Supplier')->search($entity),
    				'products' => $em->getRepository('JLMProductBundle:Product')->search($entity),
    				'persons' => $em->getRepository('JLMContactBundle:Person')->search($entity),
    		);
    	}
    	return array();
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
    	$quotes = $em->getRepository('JLMCommerceBundle:Quote')->findAll();
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
