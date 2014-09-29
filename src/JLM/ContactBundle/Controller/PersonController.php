<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Form\Type\PersonType;

/**
 * Person controller.
 */
class PersonController extends Controller
{
    /**
     * Finds and displays a Person entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showajaxAction(Person $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to create a new Person entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newajaxAction()
    {
        $entity = new Person();
        $form   = $this->createForm(new PersonType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Person entity.
     *
     * @Method("post")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function createajaxAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $entity  = new Person();
        $form    = $this->createForm(new PersonType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            if ($entity->getAddress() !== null) 
           		$em->persist($entity->getAddress());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('jlm_contact_ajax_person_show', array('id' => $entity->getId())));
            
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Trustee entity.
     *
     * Route("/ajax/{id}/edit", name="person_edit_ajax")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Person $entity)
    {
        $editForm = $this->createForm(new PersonType(), $entity);
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Trustee entity.
     *
     * Route("/ajax/{id}/update", name="person_update")
     * @Method("post")
     * @Template("JLMModelBundle:Trustee:editajax.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, Person $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm   = $this->createForm(new PersonType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
        	if ($entity->getAddress() !== null)
        	{
        		$em->persist($entity->getAddress());
        	}
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('person_show_ajax', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
}