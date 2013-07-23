<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Person;
use JLM\ModelBundle\Form\Type\PersonType;

/**
 * Person controller.
 *
 * @Route("/person")
 */
class PersonController extends Controller
{
//  /**
//   * Lists all Trustee entities.
//   *
//   * @Route("/", name="person")
//   * @Route("/page/{page}", name="person_page")
//   * @Template()
//   * @Secure(roles="ROLE_USER")
//   */
//  public function indexAction($page = 1)
//  {
//      $limit = 15;
//      $em = $this->getDoctrine()->getEntityManager();
//      $repo = $em->getRepository('JLMModelBundle:Person');
//      $nb = $repo->getTotal();
//      $nbPages = ceil($nb/$limit);
//      $nbPages = ($nbPages < 1) ? 1 : $nbPages;
//      $offset = ($page-1) * $limit;
//      if ($page < 1 || $page > $nbPages)
//      {
//      	throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
//      }
//
//      $entities = $repo->getList($limit,$offset); 
//
//      return array(
//      	'entities' => $entities,
//      	'page'     => $page,
//      	'nbPages'  => $nbPages,
//      );
//  }
//
    /**
     * Finds and displays a Person entity.
     *
     * @Route("/ajax/{id}/show", name="person_show_ajax")
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
     * @Route("/ajax/new", name="person_new_ajax")
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
     * @Route("/ajax/create", name="person_create_ajax")
     * @Method("post")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function createajaxAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
        $entity  = new Person();
        $request = $this->getRequest();
        $form    = $this->createForm(new PersonType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();
            if ($entity->getAddress() !== null) 
           		$em->persist($entity->getAddress());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('person_show_ajax', array('id' => $entity->getId())));
            
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Trustee entity.
     *
     * @Route("/ajax/{id}/edit", name="person_edit_ajax")
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
     * @Route("/ajax/{id}/update", name="person_update")
     * @Method("post")
     * @Template("JLMModelBundle:Trustee:editajax.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Person $entity)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $editForm   = $this->createForm(new PersonType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
        	if ($entity->getAddress() !== null)
        		$em->persist($entity->getAddress());
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