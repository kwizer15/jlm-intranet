<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Mail;
use JLM\ModelBundle\Form\Type\MailType;
use JLM\OfficeBundle\Entity\Quote;
use JLM\OfficeBundle\Form\Type\QuoteType;
use JLM\OfficeBundle\Entity\QuoteLine;



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
     * @Route("/page/{page}", name="quote_page")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction($page = 1)
    {
    	$limit = 10;
        $em = $this->getDoctrine()->getEntityManager();
           
        $nb = $em->getRepository('JLMOfficeBundle:Quote')->getTotal();
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }
        
        $entities = $em->getRepository('JLMOfficeBundle:Quote')->findBy(
        		array(),
        		array('number'=>'desc'),
        		$limit,
        		$offset
        );
        
        return array(
        		'entities' => $entities,
        		'page'     => $page,
        		'nbPages'  => $nbPages,
        );
    }
    
    /**
     * Lists lasts Quote entities.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function lastAction($limit = 10)
    {
    	$em = $this->getDoctrine()->getEntityManager();

    	$entities = $em->getRepository('JLMOfficeBundle:Quote')->findBy(
    			array(),
    			array('number'=>'desc'),
    			$limit
    	);
    
    	return array(
    			'entities' => $entities,
    	);
    }

    /**
     * Finds and displays a Quote entity.
     *
     * @Route("/{id}/show", name="quote_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
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
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
        $entity = new Quote();
        $entity->setCreation(new \DateTime);
      //  $entity->addLine(new QuoteLine);
        $em = $this->getDoctrine()->getEntityManager();
        $vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
		$entity->setVat($vat);
		$entity->setVatTransmitter($vat);
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
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new Quote();
        $form    = $this->createForm(new QuoteType(), $entity);
        $form->bind($request);
		
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();
            $number = $entity->getCreation()->format('ym');
            $n = ($em->getRepository('JLMOfficeBundle:Quote')->getLastNumber() + 1);
            for ($i = strlen($n); $i < 4 ; $i++)
            	$number.= '0';
            $number.= $n;
            $entity->setNumber($number);
            $em->persist($entity);
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
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Quote $entity)
    {
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->getState())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
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
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, Quote $entity)
    {
    	
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->isValid())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    	 
        $editForm = $this->createForm(new QuoteType(), $entity);
        $editForm->bind($request);
        
        if ($editForm->isValid()) {
        	$em = $this->getDoctrine()->getEntityManager();
        	$em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
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
     * @Secure(roles="ROLE_USER")
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
}
