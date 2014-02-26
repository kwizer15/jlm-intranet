<?php

namespace Kwizer\CustomFormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Kwizer\CustomFormBundle\Entity\Field;
use Kwizer\CustomFormBundle\Entity\FieldType;
use Kwizer\CustomFormBundle\Entity\FieldList;
use Kwizer\CustomFormBundle\Form\ConcreteType;
use Kwizer\CustomFormBundle\Entity\Concrete;
use Kwizer\CustomFormBundle\Entity\ConcreteField;

class DefaultController extends Controller
{
	/**
	 * Search
	 * @Template()
	 */
    public function indexAction()
    {
    	$fieldtext = new FieldType('Texte','text');	// Champ text
    	$fielddate = new FieldType('Date','date'); // Champ date
    	
    	$field1 = new ConcreteField('rapport', $fieldtext, array('label'=>'Rapport'));	// Champ nommé rapport de type text (label Rapport)
    	$field2 = new ConcreteField('datefin', $fielddate); // Champ nommé datefin de type date
    	
    	$auditType = new \Kwizer\CustomFormBundle\Entity\ConcreteType(1, 'Audit');	// Type d'intervention Audit
    	$auditType->addField($field1);	// Avec un champ additionnel "rapport"
    	$auditType->addField($field2);	// et un champ "datefin"
    	
    	$audit = new Concrete(2, $auditType);			// Nouvel audit
   		
    	$form = $this->createForm(new ConcreteType(), $audit);
    	return array('form'=>$form->createView());
//        return $this->render('KwizerCustomFormBundle:Default:index.html.twig', array('name' => $name));
    }
}
