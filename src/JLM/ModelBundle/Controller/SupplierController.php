<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Supplier;
use JLM\ModelBundle\Form\Type\SupplierType;

/**
 * Supplier controller.
 *
 * @Route("/supplier")
 */
class SupplierController extends Controller
{
    /**
     * Lists all Supplier entities.
     *
     * @Route("/", name="supplier")
     * @Route("/page/{page}", name="supplier_page")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction($page = 1)
    {
    	$limit = 15;
        $em = $this->getDoctrine()->getEntityManager();
        $nb = $em->getRepository('JLMModelBundle:Supplier')->getTotal();
        $nbPages = ceil($nb/$limit);
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }

        $entities = $em->getRepository('JLMModelBundle:Supplier')->findBy(
        		array(),
        		array('name' => 'asc'),
        		$limit,
        		$offset
        		);

        return array(
        	'entities' => $entities,
        	'page'     => $page,
        	'nbPages'  => $nbPages,
        );
    }

    /**
     * Finds and displays a Supplier entity.
     *
     * @Route("/{id}/show", name="supplier_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(Supplier $entity)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $products = $em->getRepository('JLMModelBundle:Product')->findBy(
        		array('supplier' => $entity),
        		array('designation'=>'asc')
        );
        
        return array(
            'entity'      => $entity,
        	'products'	  => $products,
        );
    }

    /**
     * Displays a form to create a new Supplier entity.
     *
     * @Route("/new", name="supplier_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
        $entity = new Supplier();
        $form   = $this->createForm(new SupplierType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Supplier entity.
     *
     * @Route("/create", name="supplier_create")
     * @Method("post")
     * @Template("JLMModelBundle:Supplier:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction()
    {
        $entity  = new Supplier();
        $request = $this->getRequest();
        $form    = $this->createForm(new SupplierType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity->getAddress());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('supplier_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Supplier entity.
     *
     * @Route("/{id}/edit", name="supplier_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Supplier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Supplier entity.');
        }

        $editForm = $this->createForm(new SupplierType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Supplier entity.
     *
     * @Route("/{id}/update", name="supplier_update")
     * @Method("post")
     * @Template("JLMModelBundle:Supplier:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Supplier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Supplier entity.');
        }

        $editForm   = $this->createForm(new SupplierType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
        	$em->persist($entity->getAddress());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('supplier_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Supplier entity.
     *
     * @Route("/{id}/delete", name="supplier_delete")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:Supplier')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Supplier entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('supplier'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
