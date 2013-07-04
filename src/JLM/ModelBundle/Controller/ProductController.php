<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Transmitter;
use JLM\ModelBundle\Entity\Product;
use JLM\ModelBundle\Form\Type\ProductType;

/**
 * Product controller.
 *
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/", name="product")
     * @Route("/page/{page}", name="product_page")
     * @Route("/page/{page}/{limit}", name="product_page_limit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction($page = 1, $limit = 15)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $nb = $em->getRepository('JLMModelBundle:Product')->getTotal();
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page inexistante (page '.$page.'/'.$nbPages.')');
        }

        $entities = $em->getRepository('JLMModelBundle:Product')->findBy(
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
     * @Route("/{id}/show", name="product_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/new", name="product_new")
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
        
        $form   = $this->createForm(new ProductType(), $entity);
        	
        	
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Product entity.
     *
     * @Route("/create", name="product_create")
     * @Method("post")
     * @Template("JLMModelBundle:Product:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction()
    {
        $entity  = new Product();
        $request = $this->getRequest();
 
        
        $form    = $this->createForm(new ProductType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('product_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Product $entity)
    {
        $editForm = $this->createForm(new ProductType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Product entity.
     *
     * @Route("/{id}/update", name="product_update")
     * @Method("post")
     * @Template("JLMModelBundle:Product:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Product $entity)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $editForm   = $this->createForm(new ProductType(), $entity);

        $request = $this->getRequest();
        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('product_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}/delete", name="product_delete")
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
            $entity = $em->getRepository('JLMModelBundle:Product')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('product'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
