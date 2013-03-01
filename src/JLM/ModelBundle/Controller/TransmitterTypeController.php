<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\TransmitterType;
use JLM\ModelBundle\Form\Type\TransmitterTypeType;

/**
 * TransmitterType controller.
 *
 * @Route("/transmittertype")
 */
class TransmitterTypeController extends Controller
{
    /**
     * Lists all TransmitterType entities.
     *
     * @Route("/", name="transmittertype")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:TransmitterType')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Displays a form to create a new TransmitterType entity.
     *
     * @Route("/new", name="transmittertype_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
        $entity = new TransmitterType();
        $form   = $this->createForm(new TransmitterTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new TransmitterType entity.
     *
     * @Route("/create", name="transmittertype_create")
     * @Method("post")
     * @Template("JLMModelBundle:TransmitterType:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction()
    {
        $entity  = new TransmitterType();
        $request = $this->getRequest();
        $form    = $this->createForm(new TransmitterTypeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('transmittertype'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing TransmitterType entity.
     *
     * @Route("/{id}/edit", name="transmittertype_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(TransmitterType $entity)
    {
        $editForm = $this->createForm(new TransmitterTypeType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing TransmitterType entity.
     *
     * @Route("/{id}/update", name="transmittertype_update")
     * @Method("post")
     * @Template("JLMModelBundle:TransmitterType:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(TransmitterType $entity)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $editForm   = $this->createForm(new TransmitterTypeType(), $entity);
        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('transmittertype'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
}
