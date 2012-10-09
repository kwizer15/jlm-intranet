<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Phone;
use JLM\ModelBundle\Form\PhoneType;

/**
 * Phone controller.
 *
 * @Route("/phone")
 */
class PhoneController extends Controller
{
    /**
     * Lists all Phone entities.
     *
     * @Route("/", name="phone")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:Phone')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Phone entity.
     *
     * @Route("/{id}/show", name="phone_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Phone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Phone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Phone entity.
     *
     * @Route("/new", name="phone_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Phone();
        $form   = $this->createForm(new PhoneType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Phone entity.
     *
     * @Route("/create", name="phone_create")
     * @Method("post")
     * @Template("JLMModelBundle:Phone:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Phone();
        $request = $this->getRequest();
        $form    = $this->createForm(new PhoneType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('phone_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Phone entity.
     *
     * @Route("/{id}/edit", name="phone_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Phone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Phone entity.');
        }

        $editForm = $this->createForm(new PhoneType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Phone entity.
     *
     * @Route("/{id}/update", name="phone_update")
     * @Method("post")
     * @Template("JLMModelBundle:Phone:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Phone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Phone entity.');
        }

        $editForm   = $this->createForm(new PhoneType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('phone_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Phone entity.
     *
     * @Route("/{id}/delete", name="phone_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:Phone')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Phone entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('phone'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
