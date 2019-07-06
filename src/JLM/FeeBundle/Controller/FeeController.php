<?php
namespace JLM\FeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\FeeBundle\Entity\Fee;
use JLM\FeeBundle\Form\Type\FeeType;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class FeeController extends Controller
{
	/**
	 * Lists all Contract entities.
	 *
	 * @Route("/", name="fee")
	 * @Template()
	 */
	public function indexAction()
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('JLMFeeBundle:Fee')->findAll();
		return array('entities' => $entities);
	}
	
	/**
	 * Finds and displays a Fee entity.
	 *
	 * @Route("/{id}/show", name="fee_show")
	 * @Template()
	 */
	public function showAction(Fee $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		return array(
				'entity'      => $entity,
			);
	}
	
	/**
	 * Displays a form to create a new Fee entity.
	 *
	 * @Route("/new", name="fee_new")
	 * @Template()
	 */
	public function newAction()
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function createAction()
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity  = new Fee();
		$request = $this->getRequest();
		$form    = $this->createForm(new FeeType(), $entity);
		$form->handleRequest($request);
	
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
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
	 */
	public function editAction(Fee $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function updateAction(Fee $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$editForm   = $this->createForm(new FeeType(), $entity);	
		$request = $this->getRequest();
		$editForm->handleRequest($request);
	
		if ($editForm->isValid()) {
			$em = $this->getDoctrine()->getManager();
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