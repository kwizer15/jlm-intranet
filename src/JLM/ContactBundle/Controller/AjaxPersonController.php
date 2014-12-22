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
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ContactBundle\Manager\ContactManager;
use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Entity\Person;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Person controller.
 */
class AjaxPersonController extends Controller
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
    	$manager = $this->container->get('jlm_contact.contact_manager');
    	$entity = $manager->getEntity('person');
        $form = $manager->createForm('POST',$entity);
        

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Person entity.
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function createajaxAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $entity  = ContactManager::create('Person');
        $form    = $this->createForm(new PersonType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            if ($entity->getAddress() !== null)
            {
           		$em->persist($entity->getAddress());
            }
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
     * Return JSON list of Person entity.
     */
    public function autocompleteAction()
    {
        $request = $this->get('request');
        $query = $request->request->get('term');
    
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('JLMContactBundle:Person')->searchResult($query);
        $json = json_encode($results);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($json);
        return $response;
    }
    
    /**
     * Person json
     */
    public function searchAction()
    {
    	$request = $this->get('request');
    	$term = $request->get('q');
    	$page_limit = $request->get('page_limit');
    	$em = $this->getDoctrine()->getManager();
    	$persons = $em->getRepository('JLMContactBundle:Person')->getArray($term, $page_limit);
    	
    	return new JsonResponse(array('persons' => $persons));
    }
    
    /**
     * Person json
     */
    public function jsonAction()
    {
    	$request = $this->get('request');
    	$id = $request->get('id');
    	$em = $this->getDoctrine()->getManager();
    	$person = $em->getRepository('JLMContactBundle:Person')->getByIdToArray($id);
    
    	return new JsonResponse($person);
    }
}