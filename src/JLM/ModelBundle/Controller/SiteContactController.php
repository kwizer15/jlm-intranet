<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\SiteContact;
use JLM\ModelBundle\Form\Type\SiteContactType;

/**
 * SiteContact controller.
 *
 * @Route("/sitecontact")
 */
class SiteContactController extends Controller
{
    /**
     * Lists all SiteContact entities.
     *
     * @Route("/", name="sitecontact")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMModelBundle:SiteContact')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a SiteContact entity.
     *
     * @Route("/{id}/show", name="sitecontact_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(SiteContact $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to create a new SiteContact entity.
     *
     * @Route("/new", name="sitecontact_new")
     * @Route("/new/{id}", name="sitecontact_new_id")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction(Site $site = null)
    {
        $entity = new SiteContact();
        if ($site)
        	$entity->setAdministrator($site);
        $form   = $this->createForm(new SiteContactType(), $entity);

        return array(
            'entity' => $entity,
        	'site' => $site,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new SiteContact entity.
     *
     * @Route("/create", name="sitecontact_create")
     * @Route("/create/{id}", name="sitecontact_create_id")
     * @Method("POST")
     * @Template("JLMModelBundle:SiteContact:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request, Site $site = null)
    {
        $entity  = new SiteContact();
        $form = $this->createForm(new SiteContactType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            if ($entity->getPerson()->getAddress() !== null)
            {
            	$em->persist($entity->getPerson()->getAddress());
            }
            //$entity->getPerson()->formatPhones();
            $em->persist($entity->getPerson());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sitecontact_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
        	'site' => $site,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SiteContact entity.
     *
     * @Route("/{id}/edit", name="sitecontact_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMModelBundle:SiteContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SiteContact entity.');
        }

        $editForm = $this->createForm(new SiteContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing SiteContact entity.
     *
     * @Route("/{id}/update", name="sitecontact_update")
     * @Method("POST")
     * @Template("JLMModelBundle:SiteContact:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMModelBundle:SiteContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SiteContact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SiteContactType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
        	if ($entity->getPerson()->getAddress() !== null)
        	{
        		$em->persist($entity->getPerson()->getAddress());
        	}
        	$entity->getPerson()->formatPhones();
        	$em->persist($entity->getPerson());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sitecontact_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SiteContact entity.
     *
     * @Route("/{id}/delete", name="sitecontact_delete")
     * @Method("POST")
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JLMModelBundle:SiteContact')->find($id);

            if (!$entity)
            {
                throw $this->createNotFoundException('Unable to find SiteContact entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sitecontact'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
