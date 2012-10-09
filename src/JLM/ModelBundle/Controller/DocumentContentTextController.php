<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\DocumentContentText;
use JLM\ModelBundle\Form\DocumentContentTextType;

/**
 * DocumentContentText controller.
 *
 * @Route("/documentcontenttext")
 */
class DocumentContentTextController extends Controller
{
    /**
     * Lists all DocumentContentText entities.
     *
     * @Route("/", name="documentcontenttext")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:DocumentContentText')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a DocumentContentText entity.
     *
     * @Route("/{id}/show", name="documentcontenttext_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DocumentContentText')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentContentText entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new DocumentContentText entity.
     *
     * @Route("/new", name="documentcontenttext_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DocumentContentText();
        $form   = $this->createForm(new DocumentContentTextType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new DocumentContentText entity.
     *
     * @Route("/create", name="documentcontenttext_create")
     * @Method("post")
     * @Template("JLMModelBundle:DocumentContentText:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new DocumentContentText();
        $request = $this->getRequest();
        $form    = $this->createForm(new DocumentContentTextType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('documentcontenttext_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing DocumentContentText entity.
     *
     * @Route("/{id}/edit", name="documentcontenttext_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DocumentContentText')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentContentText entity.');
        }

        $editForm = $this->createForm(new DocumentContentTextType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing DocumentContentText entity.
     *
     * @Route("/{id}/update", name="documentcontenttext_update")
     * @Method("post")
     * @Template("JLMModelBundle:DocumentContentText:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DocumentContentText')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentContentText entity.');
        }

        $editForm   = $this->createForm(new DocumentContentTextType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('documentcontenttext_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a DocumentContentText entity.
     *
     * @Route("/{id}/delete", name="documentcontenttext_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:DocumentContentText')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DocumentContentText entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('documentcontenttext'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
