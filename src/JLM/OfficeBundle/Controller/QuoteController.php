<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Quote;
use JLM\ModelBundle\Entity\QuoteLine;
use JLM\ModelBundle\Form\QuoteType;

/**
 * Quote controller.
 *
 * @Route("/quote")
 */
class QuoteController extends Controller
{
    /**
     * Lists all Quote entities.
     *
     * @Route("/", name="quote")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:Quote')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Quote entity.
     *
     * @Route("/{id}/show", name="quote_show")
     * @Template()
     */
    public function showAction(Quote $entity)
    {
        return array('entity'=> $entity);
    }
    
    /**
     * Displays a form to create a new Quote entity.
     *
     * @Route("/new", name="quote_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Quote();
        $entity->setCreation(new \DateTime);
        $entity->setDiscount(0);
        $entity->addLine(new QuoteLine);
        $form   = $this->createForm(new QuoteType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Quote entity.
     *
     * @Route("/create", name="quote_create")
     * @Method("post")
     * @Template("JLMOfficeBundle:Quote:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Quote();
        $form    = $this->createForm(new QuoteType(), $entity);
        $form->bind($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            foreach ($entity->getLines() as $line)
            {
            	$line->setQuote($entity);
            	$em->persist($line);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Quote entity.
     *
     * @Route("/{id}/edit", name="quote_edit")
     * @Template()
     */
    public function editAction(Quote $entity)
    {
        $editForm = $this->createForm(new QuoteType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Quote entity.
     *
     * @Route("/{id}/update", name="quote_update")
     * @Method("post")
     * @Template("JLMOfficeBundle:Quote:edit.html.twig")
     */
    public function updateAction(Request $request, Quote $entity)
    {
        $originalLines = array();
        foreach ($entity->getLines() as $line)
        	$originalLines[] = $line;
        $editForm = $this->createForm(new QuoteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
        	$em = $this->getDoctrine()->getEntityManager();
        	$em->persist($entity);
        	foreach ($entity->getLines() as $line)
        	{
        		// Nouvelles lignes
        		$line->setQuote($entity);
        		$em->persist($line);
        		
        		// On vire les anciennes
        		foreach ($originalLines as $key => $toDel) 
        			if ($toDel->getId() === $line->getId()) 
        				unset($originalLines[$key]);
        	}
        	foreach ($originalLines as $line)
        	{
        		$em->remove($line);
        	}

            $em->flush();
            return $this->redirect($this->generateUrl('quote_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Quote entity.
     *
     * @Route("/{id}/delete", name="quote_delete")
     * @Method("post")
     */
    public function deleteAction(Request $request, Quote $quote)
    {
        $form = $this->createDeleteForm($quote->getId());
        $form->bind($request);
        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('quote'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Autocomplete door
     *
     * @Route("/autocomplete/door", name="quote_auto_door")
     * @Method("post")
     */
    public function autodoorAction(Request $request)
    {
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getEntityManager();
    	$results = $em->getRepository('JLMModelBundle:Door')->searchResult($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    	 
    	return $response;
    }
    
   /**
    * Autocomplete product
    *
    * @Route("/autocomplete/product/reference", name="quote_auto_product_reference")
    * @Method("post")
    */
   public function autoproductreferenceAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:Product')->searchReference($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   
   	return $response;
   }
   
   /**
    * Autocomplete product
    *
    * @Route("/autocomplete/product/designation", name="quote_auto_product_designation")
    * @Method("post")
    */
   public function autoproductdesignationAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:Product')->searchDesignation($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   	 
   	return $response;
   }
   
   /**
    * Autocomplete intro
    *
    * @Route("/autocomplete/intro", name="quote_auto_intro")
    * @Method("post")
    */
   public function autointroAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:IntroModel')->searchResult($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   	 
   	return $response;
   }
   
   /**
    * Autocomplete delay
    *
    * @Route("/autocomplete/delay", name="quote_auto_delay")
    * @Method("post")
    */
   public function autodelayAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:DelayModel')->searchResult($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   	 
   	return $response;
   }
   
   /**
    * Autocomplete payment
    *
    * @Route("/autocomplete/payment", name="quote_auto_payment")
    * @Method("post")
    */
   public function autopaymentAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:PaymentModel')->searchResult($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   	 
   	return $response;
   }
}
