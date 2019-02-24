<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\TransmitterType;
use JLM\ModelBundle\Form\Type\TransmitterTypeType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class TransmitterTypeController extends Controller
{
    /**
     * Lists all TransmitterType entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMModelBundle:TransmitterType')->findAll();

        return ['entities' => $entities];
    }

    /**
     * Displays a form to create a new TransmitterType entity.
     *
     * @Template()
     */
    public function newAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new TransmitterType();
        $form   = $this->createForm(TransmitterTypeType::class, $entity);

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Creates a new TransmitterType entity.
     *
     * @Template("JLMModelBundle:TransmitterType:new.html.twig")
     */
    public function createAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity  = new TransmitterType();
        $request = $this->getRequest();
        $form    = $this->createForm(TransmitterTypeType::class, $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('transmittertype'));
        }

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Displays a form to edit an existing TransmitterType entity.
     *
     * @Template()
     */
    public function editAction(TransmitterType $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm = $this->createForm(TransmitterTypeType::class, $entity);
        return [
                'entity'    => $entity,
                'edit_form' => $editForm->createView(),
               ];
    }

    /**
     * Edits an existing TransmitterType entity.
     *
     * @Template("JLMModelBundle:TransmitterType:edit.html.twig")
     */
    public function updateAction(TransmitterType $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $editForm   = $this->createForm(TransmitterTypeType::class, $entity);
        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('transmittertype'));
        }

        return [
                'entity'    => $entity,
                'edit_form' => $editForm->createView(),
               ];
    }
}
