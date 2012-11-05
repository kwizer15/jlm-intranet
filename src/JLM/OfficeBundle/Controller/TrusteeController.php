<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ModelBundle\Form\TrusteeType;
use JLM\ModelBundle\Entity\Person;
use JLM\ModelBundle\Form\PersonType;

/**
 * Trustee controller.
 *
 * @Route("/trustee")
 */
class TrusteeController extends Controller
{
    /**
     * Lists all Trustee entities.
     *
     * @Route("/", name="trustee")
     * @Route("/page/{page}", name="trustee_page")
     * @Template()
     */
    public function indexAction($page = 1)
    {
        $limit = 15;
        $em = $this->getDoctrine()->getEntityManager();
        $nb = $em->getRepository('JLMModelBundle:Trustee')->getTotal();
        $nbPages = ceil($nb/$limit);
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }

        $entities = $em->getRepository('JLMModelBundle:Trustee')->findBy(
        		array(),
        		array('name' => 'asc'),
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
     * Finds and displays a Trustee entity.
     *
     * @Route("/{id}/show", name="trustee_show")
     * @Template()
     */
    public function showAction(Trustee $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Trustee entity.
     *
     * @Route("/new", name="trustee_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Trustee();
        $form   = $this->createForm(new TrusteeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Trustee entity.
     *
     * @Route("/create", name="trustee_create")
     * @Method("post")
     * @Template("JLMOfficeBundle:Trustee:new.html.twig")
     */
    public function createAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
        $entity  = new Trustee();
        $request = $this->getRequest();
        $form    = $this->createForm(new TrusteeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager(); 
            $em->persist($entity->getAddress());
            if ($entity->getBillingAddress() !== null)
          	  $em->persist($entity->getBillingAddress());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('trustee_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Trustee entity.
     *
     * @Route("/{id}/edit", name="trustee_edit")
     * @Template()
     */
    public function editAction(Trustee $entity)
    {
        $editForm = $this->createForm(new TrusteeType(), $entity);
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Trustee entity.
     *
     * @Route("/{id}/update", name="trustee_update")
     * @Method("post")
     * @Template("JLMOfficeBundle:Trustee:edit.html.twig")
     */
    public function updateAction(Trustee $entity)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $editForm   = $this->createForm(new TrusteeType(), $entity);
        $deleteForm = $this->createDeleteForm($entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
        	$em->persist($entity->getAddress());
        	if ($entity->getBillingAddress() !== null)
        		$em->persist($entity->getBillingAddress());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('trustee_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Trustee entity.
     *
     * @Route("/{id}/delete", name="trustee_delete")
     * @Method("post")
     */
    public function deleteAction(Trustee $entity)
    {
        $form = $this->createDeleteForm($entity);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('trustee'));
    }

    private function createDeleteForm(Trustee $entity)
    {
        return $this->createFormBuilder(array('id' => $entity->getId()))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Formulaire d'ajout d'un contact au syndic.
     *
     * @Route("/{id}/contact/new", name="trustee_contact_new")
     * @Template()
     */
    public function contactnewAction(Trustee $trustee)
    {
    	$entity = new Person();
    	$form   = $this->createForm(new PersonType(), $entity);
    	
    	return array(
    			'trustee' => $trustee,
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }
    
    /**
     * Creates a new Trustee entity.
     *
     * @Route("/{id}/contact/create", name="trustee_contact_create")
     * @Method("post")
     * @Template("JLMOfficeBundle:Trustee:contactnew.html.twig")
     */
    public function contactcreateAction(Trustee $trustee)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$entity  = new Person();
    	$request = $this->getRequest();
    	$form    = $this->createForm(new PersonType(), $entity);
    	$form->bindRequest($request);
    
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getEntityManager();
    		$trustee->addContact($entity);
    		$em->persist($entity);
			$em->persist($trustee);
    		$em->flush();
    
    		return $this->redirect($this->generateUrl('trustee_show', array('id' => $trustee->getId())));
    
    	}
    
    	return array(
    			'trustee' => $trustee,
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }
}
