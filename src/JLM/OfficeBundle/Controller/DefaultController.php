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
     * Creates a new Product entity.
     *
     * @Route("/create", name="test_create")
     * @Method("post")
     * @Template("JLMOfficeBundle:Default:new.html.twig")
     */
    public function createAction()
    {
    	$entity  = new Address();
    	$request = $this->getRequest();
    	$form    = $this->createForm(new AddressType(), $entity);
    	$form->bindRequest($request);
    
 //   	var_dump($entity);
    	
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->persist($entity);
    		$em->flush();
    
    		return $this->redirect($this->generateUrl('test_show', array('id' => $entity->getId())));
    
    	}
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }
    
    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}/show", name="test_show")
     * @Template()
     */
    public function showAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    
    	$entity = $em->getRepository('JLMModelBundle:Address')->find($id);
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find Address entity.');
    	}
    
    	//$deleteForm = $this->createDeleteForm($id);
    
    	return array(
    			'entity'      => $entity,
    	//		'delete_form' => $deleteForm->createView(),       
    	 );
    }
}
