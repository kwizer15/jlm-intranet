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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\SiteContact;
use JLM\ModelBundle\Form\Type\SiteContactType;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SiteContactController extends Controller
{
    /**
     * Lists all SiteContact entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMModelBundle:SiteContact')->findAll();

        return ['entities' => $entities];
    }

    /**
     * Finds and displays a SiteContact entity.
     *
     * @Template()
     */
    public function showAction(SiteContact $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return ['entity' => $entity];
    }

    /**
     * Displays a form to create a new SiteContact entity.
     *
     * @Template()
     */
    public function newAction(Site $site = null)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new SiteContact();
        if ($site) {
            $entity->setAdministrator($site);
        }
        $form   = $this->createForm(new SiteContactType(), $entity);

        return [
                'entity' => $entity,
                'site'   => $site,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Creates a new SiteContact entity.
     *
     * @Template("JLMModelBundle:SiteContact:new.html.twig")
     */
    public function createAction(Request $request, Site $site = null)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity  = new SiteContact();
        $form = $this->createForm(new SiteContactType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($entity->getPerson()->getAddress() !== null) {
                $em->persist($entity->getPerson()->getAddress());
            }
            //$entity->getPerson()->formatPhones();
            $em->persist($entity->getPerson());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sitecontact_show', ['id' => $entity->getId()]));
        }

        return [
                'entity' => $entity,
                'site'   => $site,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Displays a form to edit an existing SiteContact entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMModelBundle:SiteContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SiteContact entity.');
        }

        $editForm = $this->createForm(new SiteContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return [
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
               ];
    }

    /**
     * Edits an existing SiteContact entity.
     *
     * @Template("JLMModelBundle:SiteContact:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMModelBundle:SiteContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SiteContact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SiteContactType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($entity->getPerson()->getAddress() !== null) {
                $em->persist($entity->getPerson()->getAddress());
            }
            //$entity->getPerson()->formatPhones();
            $em->persist($entity->getPerson());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sitecontact_show', ['id' => $id]));
        }

        return [
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
               ];
    }

    /**
     * Deletes a SiteContact entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JLMModelBundle:SiteContact')->find($id);

        if ($entity !== null) {
            $em->remove($entity);
            $em->flush();
        }
        
        return new RedirectResponse($request->headers->get('referer'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
