<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Employee;
use JLM\ModelBundle\Form\EmployeeType;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array('name'=>'Bonjour');
    }
    
    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/new", name="test_new")
     * @Template()
     */
    public function newAction()
    {
    	$entity = new Employee();
    	$form   = $this->createForm(new EmployeeType(), $entity);
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }
}
