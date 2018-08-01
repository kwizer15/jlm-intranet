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
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Form\Type\SiteType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SiteController extends Controller
{
    /**
     * Lists all Site entities.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMModelBundle:Site')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Site entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMModelBundle:Site')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Site entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Site entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function newAction()
    {
    	$trustee = $this->getRequest()->get('trustee', null);
        $entity = new Site();
        $form   = $this->createForm(new SiteType(), $entity);
        $em = $this->get('doctrine')->getManager();
        $form->get('trustee')->setData($em->getRepository('JLMModelBundle:Trustee')->find($trustee));

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Site entity.
     *
     * @Template("JLMModelBundle:Site:new.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function createAction(Request $request)
    {
        $entity  = new Site();
        $form = $this->createForm(new SiteType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity->getAddress());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('site_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Site entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function editAction(Site $entity)
    {
        $editForm = $this->createForm(new SiteType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Site entity.
     *
     * @Template("JLMModelBundle:Site:edit.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function updateAction(Request $request, Site $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $editForm = $this->createForm(new SiteType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
        	$em->persist($entity->getAddress());
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('site_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Site entity.
     *
     * @Secure(roles="ROLE_OFFICE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JLMModelBundle:Site')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Site entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('site'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
