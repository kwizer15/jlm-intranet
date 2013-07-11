<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Address;
use JLM\ModelBundle\Form\Type\AddressType;

class AutocompleteController extends Controller
{
    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/autocomplete/city", name="autocomplete_city")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function cityAction()
    {
    	$request = $this->get('request');
    	$query = $request->request->get('term');

    	$em = $this->getDoctrine()->getEntityManager();
    	$results = $em->getRepository('JLMModelBundle:City')->searchResult($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    	return $response;
    }
    
    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/autocomplete/person", name="autocomplete_person")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function personAction()
    {
    	$request = $this->get('request');
    	$query = $request->request->get('term');
    
    	$em = $this->getDoctrine()->getEntityManager();
    	$results = $em->getRepository('JLMModelBundle:Person')->searchResult($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    	return $response;
    }
    
    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/autocomplete/trustee", name="autocomplete_trustee")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function trusteeAction()
    {
    	$request = $this->get('request');
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getEntityManager();
    	$results = $em->getRepository('JLMModelBundle:Trustee')->searchResult($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    	
    	return $response;
    }
    
    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/autocomplete/site", name="autocomplete_site")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function siteAction()
    {
    	$request = $this->get('request');
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getEntityManager();
    	$results = $em->getRepository('JLMModelBundle:Site')->searchResult($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    	 
    	return $response;
    }
    
    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/autocomplete/contract", name="autocomplete_contract")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function contractAction()
    {
    	$request = $this->get('request');
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getEntityManager();
    	$results = $em->getRepository('JLMModelBundle:Contract')->searchResult($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    
    	return $response;
    }
    
    /**
     * @Route("/autocomplete", name="autocomplete")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction(Request $request)
    {
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getEntityManager();  	
    	$repository = $request->request->get('repository');
    	$action = $request->request->get('action');
    	$action = empty($action) ? 'Result' : $action;
    	$action = 'search'.$action;
    	$results = $em->getRepository($repository)->$action($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json); 
    	return $response;
    }
    
    /**
     * @Route("/autocomplete/doorsite", name="autocomplete_doorsite")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function doorsite(Request $request)
    {
    	$id = $request->request->get('id_site');
    	$em = $this->getDoctrine()->getEntityManager();
    	$site = $em->getRepository('JLMModelBundle:Site')->find($id);
    	$results = $em->getRepository('JLMModelBundle:Door')->findBy(array('site'=>$site));
    	foreach($results as $result)
    	{
    		$doors[] = array(
    				'id'=>$result->getId(),
    				'string'=>$result->getType().' - '.$result->getLocation().' / '.$result->getStreet()
    		);
    	}
    	$json = json_encode($doors);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    	return $response;
    }

}
