<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\LinkedFile;
use JLM\ModelBundle\Form\LinkedFileType;

/**
 * LinkedFile controller.
 *
 * @Route("/linkedfile")
 */
class LinkedFileController extends Controller
{
    /**
     * Lists all LinkedFile entities.
     *
     * @Route("/", name="linkedfile")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:LinkedFile')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a LinkedFile entity.
     *
     * @Route("/{id}/show", name="linkedfile_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:LinkedFile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LinkedFile entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new LinkedFile entity.
     *
     * @Route("/new", name="linkedfile_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new LinkedFile();
        $form   = $this->createForm(new LinkedFileType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new LinkedFile entity.
     *
     * @Route("/create", name="linkedfile_create")
     * @Method("post")
     * @Template("JLMModelBundle:LinkedFile:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new LinkedFile();
        $request = $this->getRequest();
        $form    = $this->createForm(new LinkedFileType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('linkedfile_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing LinkedFile entity.
     *
     * @Route("/{id}/edit", name="linkedfile_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:LinkedFile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LinkedFile entity.');
        }

        $editForm = $this->createForm(new LinkedFileType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing LinkedFile entity.
     *
     * @Route("/{id}/update", name="linkedfile_update")
     * @Method("post")
     * @Template("JLMModelBundle:LinkedFile:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:LinkedFile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LinkedFile entity.');
        }

        $editForm   = $this->createForm(new LinkedFileType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('linkedfile_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a LinkedFile entity.
     *
     * @Route("/{id}/delete", name="linkedfile_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:LinkedFile')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find LinkedFile entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('linkedfile'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
