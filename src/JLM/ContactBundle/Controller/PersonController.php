<?php

/*
 * This file is part of the JLM package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Form\Type\PersonType;
use Doctrine\ORM\EntityManager;

/**
 * Person controller.
 *
 * @Route("/person")
 */
class PersonController extends Controller
{

    /**
     * Lists all Person entities.
     *
     * @Route("/", name="jlm_contact_person")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMContactBundle:Person')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Person entity.
     *
     * @Route("/", name="jlm_contact_person_create")
     * @Method("POST")
     * @Template("JLMContactBundle:Person:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $form = $this->createCreateForm();
        $form->handleRequest($request);
        $template = ($request->isXmlHttpRequest()) ? 'JLMContactBundle:Person:modal_new.html.twig' : 'JLMContactBundle:Person:new.html.twig';
        
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $form->getData();
            $em->persist($entity);
            $em->flush();

            if ($request->isXmlHttpRequest())
            {
            	return $this->render('JLMContactBundle:Person:modal_show.html.twig',array('entity' => $form->getData()));
            } 
            
            return $this->redirect($this->generateUrl('jlm_contact_person_show', array('id' => $entity->getId())));
        }

        return $this->render($template,array(
        		'entity' => $form->getData(),
        		'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Person entity.
    *
    * @param Person $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Person $entity = null)
    {
        $form = $this->createForm(new PersonType(), $entity, array(
            'action' => $this->generateUrl('jlm_contact_person_create'),
            'method' => 'POST',
        	'attr' => array('main_title' => 'Nouvelle personne')
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer'));

        return $form;
    }

    /**
     * Displays a form to create a new Person entity.
     *
     * @Route("/new", name="jlm_contact_person_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $form   = $this->createCreateForm();
	
        $template = ($this->getRequest()->isXmlHttpRequest()) ? 'JLMContactBundle:Person:modal_new.html.twig' : 'JLMContactBundle:Person:new.html.twig';

        return $this->render($template,array(
        		'entity' => $form->getData(),
        		'form'   => $form->createView(),
        	));
    }

    /**
     * Finds and displays a Person entity.
     *
     * @Route("/{id}", name="jlm_contact_person_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $entity = $this->getEntity($id);

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Person entity.
     *
     * @Route("/{id}/edit", name="jlm_contact_person_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $entity = $this->getEntity($id);

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $template = ($this->getRequest()->isXmlHttpRequest()) ? 'JLMContactBundle:Person:modal_edit.html.twig' : 'JLMContactBundle:Person:edit.html.twig';
        
        return $this->render($template,array(
        		'entity'      => $entity,
        		'edit_form'   => $editForm->createView(),
            	'delete_form' => $deleteForm->createView(),
        ));
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Person entity.
    *
    * @param Person $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Person $entity)
    {
        $form = $this->createForm(new PersonType(), $entity, array(
            'action' => $this->generateUrl('jlm_contact_person_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer'));

        return $form;
    }
    /**
     * Edits an existing Person entity.
     *
     * @Route("/{id}", name="jlm_contact_person_update")
     * @Method("PUT")
     * @Template("JLMContactBundle:Person:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->getEntity($id, $em);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->flush();

            return $this->redirect($this->generateUrl('jlm_contact_person_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Person entity.
     *
     * @Route("/{id}", name="jlm_contact_person_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $this->getEntity($id, $em);

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('jlm_contact_person'));
    }

    /**
     * Creates a form to delete a Person entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jlm_contact_person_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
    
    /**
     * Get entity with id
     * @param int $id
     * @return Person
     */
    private function getEntity($id, EntityManager $em = null)
    {
    	if (null === $em)
    	{
    		$em = $this->getDoctrine()->getManager();
    	}
    	
    	$entity = $em->getRepository('JLMContactBundle:Person')->find($id);
    	if (!$entity)
    	{
    		throw $this->createNotFoundException('Unable to find Person entity.');
    	}
    	
    	return $entity;
    }
}