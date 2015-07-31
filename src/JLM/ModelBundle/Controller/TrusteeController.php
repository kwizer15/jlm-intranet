<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ModelBundle\Form\Type\TrusteeType;
use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Manager\ContactManager;

/**
 * Trustee controller.
 *
 * Route("/trustee")
 */
class TrusteeController extends Controller
{
    /**
     * Lists all Trustee entities.
     *
     * Route("/", name="trustee")
     * Route("/page/{page}", name="trustee_page")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction($page = 1)
    {
        $limit = 15;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMModelBundle:Trustee');
        $nb = $repo->getTotal();
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }

        $entities = $repo->getList($limit,$offset); 

        return array(
        	'entities' => $entities,
        	'page'     => $page,
        	'nbPages'  => $nbPages,
        );
    }

    /**
     * Finds and displays a Trustee entity.
     *
     * Route("/{id}/show", name="trustee_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(Trustee $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to create a new Trustee entity.
     *
     * Route("/new", name="trustee_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
    	$request = $this->getRequest();
    	$contact = $request->get('contact');
    	$em = $this->get('doctrine')->getManager();
        $entity = new Trustee();
        $form   = $this->createForm(new TrusteeType(), $entity);
        if ($contact)
        {
        	$c = $em->getRepository('JLMContactBundle:Contact')->find($contact);
        	if ($c)
        	{
        		$form->get('contact')->setData($c);
        	}
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Trustee entity.
     *
     * Route("/create", name="trustee_create")
     * Method("post")
     * @Template("JLMModelBundle:Trustee:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction()
    {
    	$em = $this->getDoctrine()->getManager();
        $entity  = new Trustee();
        $request = $this->getRequest();
        $form    = $this->createForm(new TrusteeType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager(); 
            if ($entity->getBillingAddress() !== null)
            {
          	    $em->persist($entity->getBillingAddress());
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('trustee_show', array('id' => $entity->getId())));
            
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Trustee entity.
     *
     * Route("/{id}/edit", name="trustee_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Trustee $entity)
    {
        $editForm = $this->createForm(new TrusteeType(), $entity);
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Trustee entity.
     *
     * Route("/{id}/update", name="trustee_update")
     * Method("post")
     * @Template("JLMModelBundle:Trustee:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Trustee $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm   = $this->createForm(new TrusteeType(), $entity);
        $deleteForm = $this->createDeleteForm($entity);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
        	$em->persist($entity->getAddress());
        	if ($entity->getBillingAddress() !== null)
        	{
        		$em->persist($entity->getBillingAddress());
        	}
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('trustee_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Trustee entity.
     *
     * Route("/{id}/delete", name="trustee_delete")
     * Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction(Trustee $entity)
    {
        $form = $this->createDeleteForm($entity);
        $request = $this->getRequest();

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('trustee'));
    }

    private function createDeleteForm(Trustee $entity)
    {
        return $this->createFormBuilder(array('id' => $entity->getId()))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Formulaire d'ajout d'un contact au syndic.
     *
     * Route("/{id}/contact/new", name="trustee_contact_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function contactnewAction(Trustee $trustee)
    {
    	$entity = ContactManager::create('Person');
    	$form   = $this->createForm(new PersonType(), $entity);
    	
    	return array(
    			'trustee' => $trustee,
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }
    
    /**
     * Creates a new Trustee entity.
     *
     * Route("/{id}/contact/create", name="trustee_contact_create")
     * Method("post")
     * @Template("JLMModelBundle:Trustee:contactnew.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function contactcreateAction(Trustee $trustee)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity  = ContactManager::create('Person');
    	$request = $this->getRequest();
    	$form    = $this->createForm(new PersonType(), $entity);
    	$form->handleRequest($request);
    
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
    		$trustee->addContact($entity);
    		$em->persist($entity);
			$em->persist($trustee);
    		$em->flush();
    
    		return $this->redirect($this->generateUrl('trustee_show', array('id' => $trustee->getId())));
    
    	}
    
    	return array(
    			'trustee' => $trustee,
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }
    
    /**
     * City json
     *
     * Route("/trustees.json", name="jlm_model_trusteesearch_json")
     * Method("get")
     * @Secure(roles="ROLE_USER")
     */
    public function searchAction(Request $request)
    {
        $term = $request->get('q');
        $page_limit = $request->get('page_limit');
    
        $em = $this->getDoctrine()->getManager();
    
        $entities = $em->getRepository('JLMModelBundle:Trustee')->getArray($term, $page_limit);
        
        return new JsonResponse(array('entities' => $entities));
    }
    
    /**
     * City json
     *
     * Route("/trustee.json", name="jlm_model_trustee_json")
     * Method("get")
     * @Secure(roles="ROLE_USER")
     */
    public function jsonAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JLMModelBundle:Trustee')->getByIdToArray($id);
    
        return new JsonResponse($entity);
    }
}
