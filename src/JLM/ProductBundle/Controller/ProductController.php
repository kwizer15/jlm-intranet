<?php

namespace JLM\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ProductBundle\Entity\Product;
use JLM\ProductBundle\Form\Type\ProductType;
use Doctrine\ORM\EntityManager;
use JLM\ProductBundle\JLMProductEvents;
use JLM\ProductBundle\Event\ProductEvent;

/**
 * Product controller.
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction($page = 1, $limit = 15)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMProductBundle:Product');
        $nb = $repo->getTotal();
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page inexistante (page '.$page.'/'.$nbPages.')');
        }

        $entities = $repo->findBy(
        		array(),
        		array('reference' => 'asc'),
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
     * Finds and displays a Product entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction($id)
    {
        $entity = $this->getEntity($id);
        
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Product entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
        $entity = new Product();
        $entity->setUnity('pièce');
        $entity->setDiscountSupplier(0);
        $entity->setExpenseRatio(10);
        $entity->setShipping(0);
        $entity->setUnitPrice(0);
        
        $form   = $this->createNewForm($entity);
        	
        	
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Product entity.
     *
     * @Template("JLMProductBundle:Product:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new Product();

        $form    = $this->createNewForm($entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->dispatch(JLMProductEvents::PRODUCT_CREATE, new ProductEvent($entity));
            
            return $this->redirect($this->generateUrl('jlm_product_product_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction($id)
    {
        $entity = $this->getEntity($id);
        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Product entity.
     *
     * @Template("JLMProductBundle:Product:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->getEntity($id);
        $editForm   = $this->createEditForm($entity);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('jlm_product_product_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Product entity.
     *
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $this->getEntity($id);

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('jlm_product_product'));
    }
    
    /**
     * Get the entity from id
     * @param int $id
     * @return ProductCategory
     */
    private function getEntity($id)
    {
        $em = $this->getDoctrine()->getManager();
    
        $entity = $em->getRepository('JLMProductBundle:Product')->find($id);
    
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }
    
        return $entity;
    }
    
    /**
     * Get the delete form
     * @param int $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
        ->add('id', 'hidden')
        ->getForm()
        ;
    }
    
    /**
     * Get the edit form
     * @param ProductCategory $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createEditForm(Product $entity)
    {
        return $this->createForm(new ProductType(), $entity);
    }
    
    /**
     * Get the new form
     * @param ProductCategory $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createNewForm(Product $entity)
    {
        return $this->createForm(new ProductType(), $entity);
    }
}
