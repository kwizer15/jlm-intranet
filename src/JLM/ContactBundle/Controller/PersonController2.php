<?php

namespace JLM\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\SecurityExtraBundle\Annotation\Secure;

use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Form\Type\PersonType;

/**
 * Person controller.
 *
 * @Route("/person")
 */
class PersonController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    
    /**
     * Displays a form to create a new Person entity.
     *
     * @Route("/new", name="jlmcontact_person_new")
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {

        $form   = $this->getForm();
        $entity = $form->getData();

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Displays a form to create a new Person entity.
     *
     * @Route("/new", name="jlmcontact_person_create")
     * @Template()
     * @Method("POST")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction()
    {
    	$form   = $this->getForm();
    	$entity = $form->getData();
    	$form->handleRequest();
    	
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($entity);
    		$em->flush();
    	}
    	
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView(),
    	);
    }
    
    /**
     * Displays a form to create a new Person entity.
     *
     * @Route("/{id}/edit", name="jlmcontact_person_edit")
     * @Template()
     * @Method("GET")
     * @Secure(roles="ROLE_USER")
     */
    public function editAction($id)
    {
    	$form   = $this->getForm();
    	$entity = $form->getData();
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView(),
    	);
    }
    
    /**
     * Displays a form to create a new Person entity.
     *
     * @Route("/{id}/edit", name="jlmcontact_person_update")
     * @Template()
     * @Method("PUT")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction()
    {
    	$form   = $this->getForm();
    	$entity = $form->getData();
    	$form->handleRequest();
    	 
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($entity);
    		$em->flush();
    	}
    	 
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView(),
    	);
    }
    
    /**
     * Return the PersonType
     * @param Person $entity
     * @return \Symfony\Component\Form\Form
     */
    private function getForm(Person $entity = null)
    {
    	return $this->createForm(new PersonType(), $entity);
    }
}
