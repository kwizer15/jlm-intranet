<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ContactBundle\Entity\Address;
use JLM\ContactBundle\Form\Type\AddressType;

class AutocompleteController extends Controller
{
    /**
     * Displays a form to create a new Product entity.
     *
     * Route("/autocomplete/city", name="autocomplete_city")
     * Method("post")
     */
    public function cityAction()
    {
    	$request = $this->get('request');
    	$query = $request->request->get('term');

    	$em = $this->getDoctrine()->getManager();
    	$results = $em->getRepository('JLMContactBundle:City')->searchResult($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    	return $response;
    }
    
    /**
     * Displays a form to create a new Product entity.
     *
     * Route("/autocomplete/trustee", name="autocomplete_trustee")
     * Method("post")
     */
    public function trusteeAction()
    {
    	$request = $this->get('request');
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getManager();
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
     * Route("/autocomplete/site", name="autocomplete_site")
     * Method("post")
     */
    public function siteAction()
    {
    	$request = $this->get('request');
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getManager();
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
     * Route("/autocomplete/contract", name="autocomplete_contract")
     * Method("post")
     */
    public function contractAction()
    {
    	$request = $this->get('request');
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getManager();
    	$results = $em->getRepository('JLMContractBundle:Contract')->searchResult($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    
    	return $response;
    }
    
    /**
     * Route("/autocomplete", name="autocomplete")
     * Method("post")
     */
    public function indexAction(Request $request)
    {
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getManager();  	
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
     * Route("/autocomplete/doorsite", name="autocomplete_doorsite")
     * Method("post")
     * 
     * @todo Voir si cette action est utile car pas de "Action" dans le nom de la fonction quand j'ai réécrit le routage en yml
     */
    public function doorsiteAction(Request $request)
    {
    	$id = $request->request->get('id_site');
    	$em = $this->getDoctrine()->getManager();
    	$site = $em->getRepository('JLMModelBundle:Site')->find($id);
    	$results = $em->getRepository('JLMModelBundle:Door')->findBy(array('site'=>$site));
    	$doors = array();
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
