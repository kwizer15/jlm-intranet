<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\DocumentContentLine;
use JLM\ModelBundle\Form\DocumentContentLineType;

/**
 * DocumentContentLine controller.
 *
 * @Route("/documentcontentline")
 */
class DocumentContentLineController extends Controller
{
    /**
     * Lists all DocumentContentLine entities.
     *
     * @Route("/", name="documentcontentline")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:DocumentContentLine')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a DocumentContentLine entity.
     *
     * @Route("/{id}/show", name="documentcontentline_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DocumentContentLine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentContentLine entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new DocumentContentLine entity.
     *
     * @Route("/new", name="documentcontentline_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DocumentContentLine();
        $form   = $this->createForm(new DocumentContentLineType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new DocumentContentLine entity.
     *
     * @Route("/create", name="documentcontentline_create")
     * @Method("post")
     * @Template("JLMModelBundle:DocumentContentLine:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new DocumentContentLine();
        $request = $this->getRequest();
        $form    = $this->createForm(new DocumentContentLineType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('documentcontentline_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing DocumentContentLine entity.
     *
     * @Route("/{id}/edit", name="documentcontentline_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DocumentContentLine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentContentLine entity.');
        }

        $editForm = $this->createForm(new DocumentContentLineType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing DocumentContentLine entity.
     *
     * @Route("/{id}/update", name="documentcontentline_update")
     * @Method("post")
     * @Template("JLMModelBundle:DocumentContentLine:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DocumentContentLine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentContentLine entity.');
        }

        $editForm   = $this->createForm(new DocumentContentLineType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('documentcontentline_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a DocumentContentLine entity.
     *
     * @Route("/{id}/delete", name="documentcontentline_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:DocumentContentLine')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DocumentContentLine entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('documentcontentline'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
