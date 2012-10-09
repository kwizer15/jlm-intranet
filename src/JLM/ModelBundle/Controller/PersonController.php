<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Person;
use JLM\ModelBundle\Form\PersonType;

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
     * @Route("/", name="person")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:Person')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Person entity.
     *
     * @Route("/{id}/show", name="person_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Person entity.
     *
     * @Route("/new", name="person_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Person();
        $form   = $this->createForm(new PersonType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Person entity.
     *
     * @Route("/create", name="person_create")
     * @Method("post")
     * @Template("JLMModelBundle:Person:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Person();
        $request = $this->getRequest();
        $form    = $this->createForm(new PersonType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('person_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Person entity.
     *
     * @Route("/{id}/edit", name="person_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $editForm = $this->createForm(new PersonType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Person entity.
     *
     * @Route("/{id}/update", name="person_update")
     * @Method("post")
     * @Template("JLMModelBundle:Person:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $editForm   = $this->createForm(new PersonType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('person_edit', array('id' => $id)));
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
     * @Route("/{id}/delete", name="person_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:Person')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Person entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('person'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
