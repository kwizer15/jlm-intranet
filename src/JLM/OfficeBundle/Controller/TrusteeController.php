<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ModelBundle\Form\TrusteeType;

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
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:Trustee')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Trustee entity.
     *
     * @Route("/{id}/show", name="trustee_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Trustee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trustee entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

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
     * @Template("JLMModelBundle:Trustee:new.html.twig")
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
            if ($entity->getBillingAddress())
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
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Trustee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trustee entity.');
        }

        $editForm = $this->createForm(new TrusteeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

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
     * @Template("JLMModelBundle:Trustee:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Trustee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trustee entity.');
        }

        $editForm   = $this->createForm(new TrusteeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('trustee_edit', array('id' => $id)));
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
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:Trustee')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Trustee entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('trustee'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
