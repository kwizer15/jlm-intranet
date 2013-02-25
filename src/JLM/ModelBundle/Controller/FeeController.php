<?php
namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Fee;
use JLM\ModelBundle\Form\Type\FeeType;

/**
 * Contract controller.
 *
 * @Route("/fee")
 */
class FeeController extends Controller
{
	/**
	 * Lists all Contract entities.
	 *
	 * @Route("/", name="fee")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$entities = $em->getRepository('JLMModelBundle:Fee')->findAll();
		return array('entities' => $entities);
	}
	
	/**
	 * Finds and displays a Fee entity.
	 *
	 * @Route("/{id}/show", name="fee_show")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction(Fee $entity)
	{
	
		return array(
				'entity'      => $entity,
			);
	}
	
	/**
	 * Displays a form to create a new Fee entity.
	 *
	 * @Route("/new", name="fee_new")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function newAction()
	{
		$entity = new Fee();

		$form   = $this->createForm(new FeeType(), $entity);
	
		return array(
				'entity' => $entity,
				'form'   => $form->createView()
		);
	}
	
	/**
	 * Creates a new Fee entity.
	 *
	 * @Route("/create", name="fee_create")
	 * @Method("post")
	 * @Template("JLMModelBundle:Fee:new.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function createAction()
	{
		$entity  = new Fee();
		$request = $this->getRequest();
		$form    = $this->createForm(new FeeType(), $entity);
		$form->bindRequest($request);
	
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($entity);
			$em->flush();
	
			return $this->redirect($this->generateUrl('fee_show', array('id' => $entity->getId())));
	
		}
	
		return array(
				'entity' => $entity,
				'form'   => $form->createView()
		);
	}
	
	/**
	 * Displays a form to edit an existing Fee entity.
	 *
	 * @Route("/{id}/edit", name="fee_edit")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function editAction(Fee $entity)
	{
		$editForm = $this->createForm(new FeeType(), $entity);
	
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Edits an existing Fee entity.
	 *
	 * @Route("/{id}/update", name="fee_update")
	 * @Method("post")
	 * @Template("JLMModelBundle:Fee:edit.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function updateAction(Fee $entity)
	{
		$editForm   = $this->createForm(new FeeType(), $entity);	
		$request = $this->getRequest();
		$editForm->bindRequest($request);
	
		if ($editForm->isValid()) {
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($entity);
			$em->flush();
	
			return $this->redirect($this->generateUrl('fee_show', array('id' => $entity->getId())));
		}
	
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
}	