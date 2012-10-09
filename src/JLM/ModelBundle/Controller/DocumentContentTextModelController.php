<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\DocumentContentTextModel;
use JLM\ModelBundle\Form\DocumentContentTextModelType;

/**
 * DocumentContentTextModel controller.
 *
 * @Route("/documentcontenttextmodel")
 */
class DocumentContentTextModelController extends Controller
{
    /**
     * Lists all DocumentContentTextModel entities.
     *
     * @Route("/", name="documentcontenttextmodel")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:DocumentContentTextModel')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a DocumentContentTextModel entity.
     *
     * @Route("/{id}/show", name="documentcontenttextmodel_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DocumentContentTextModel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentContentTextModel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new DocumentContentTextModel entity.
     *
     * @Route("/new", name="documentcontenttextmodel_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DocumentContentTextModel();
        $form   = $this->createForm(new DocumentContentTextModelType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new DocumentContentTextModel entity.
     *
     * @Route("/create", name="documentcontenttextmodel_create")
     * @Method("post")
     * @Template("JLMModelBundle:DocumentContentTextModel:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new DocumentContentTextModel();
        $request = $this->getRequest();
        $form    = $this->createForm(new DocumentContentTextModelType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('documentcontenttextmodel_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing DocumentContentTextModel entity.
     *
     * @Route("/{id}/edit", name="documentcontenttextmodel_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DocumentContentTextModel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentContentTextModel entity.');
        }

        $editForm = $this->createForm(new DocumentContentTextModelType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing DocumentContentTextModel entity.
     *
     * @Route("/{id}/update", name="documentcontenttextmodel_update")
     * @Method("post")
     * @Template("JLMModelBundle:DocumentContentTextModel:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DocumentContentTextModel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentContentTextModel entity.');
        }

        $editForm   = $this->createForm(new DocumentContentTextModelType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('documentcontenttextmodel_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a DocumentContentTextModel entity.
     *
     * @Route("/{id}/delete", name="documentcontenttextmodel_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:DocumentContentTextModel')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DocumentContentTextModel entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('documentcontenttextmodel'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
