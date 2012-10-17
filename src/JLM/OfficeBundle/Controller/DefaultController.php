<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Address;
use JLM\ModelBundle\Form\AddressType;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array('name'=>'Bonjour');
    }
    
    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/new", name="test_new")
     * @Template()
     */
    public function newAction()
    {
    	$entity = new Address();
    	$form   = $this->createForm(new AddressType(), $entity);

    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView(),
    	);
    }
    
    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/autocomplete/{query}", name="test_autocomplete")
     * @Template("JLMOfficeBundle:Default:autocomplete.json.twig")
     */
    public function autocompleteAction($query)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$results = $em->getRepository('JLMModelBundle:City')->searchResult($query);
    	$json = '{"options":'.json_encode($results).'}';
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    	return $response;
    }
}
