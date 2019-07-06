<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\OfficeBundle\Entity\Order;
use JLM\OfficeBundle\Form\Type\OrderType;
use JLM\OfficeBundle\Entity\Task;
use JLM\DailyBundle\Entity\Work;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;



/**
 * @Route("/order")
 */
class OrderController extends Controller
{
	/**
	 * Lists all Order entities.
	 *
	 * @Route("/", name="order")
	 * @Route("/page/{page}", name="order_page")
	 * @Route("/page/{page}/state/{state}", name="order_state")
	 * @Template()
	 */
	public function indexAction($page = 1, $state = null)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$limit = 10;
		$em = $this->getDoctrine()->getManager();
			
		$nb = $em->getRepository('JLMOfficeBundle:Order')->getCount($state);
		$nbPages = ceil($nb/$limit);
		$nbPages = ($nbPages < 1) ? 1 : $nbPages;
		$offset = ($page-1) * $limit;
		if ($page < 1 || $page > $nbPages)
		{
			throw $this->createNotFoundException('Page inexistante (page '.$page.'/'.$nbPages.')');
		}
		
		$entities = $em->getRepository('JLMOfficeBundle:Order')->getByState(
				$state,
				$limit,
				$offset
		);
		
		return array(
				'entities' => $entities,
				'page'     => $page,
				'nbPages'  => $nbPages,
				'state' => $state,
		);
	}
	
	/**
	 * Finds and displays an Order entity.
	 *
	 * @Route("/{id}/show", name="order_show")
	 * @Template()
	 */
	public function showAction(Order $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		return array('entity'=> $entity);
	}
	
	/**
	 * Displays a form to create a new Bill entity.
	 *
	 * @Route("/new/{id}", name="order_new")
	 * @Template()
	 */
	public function newAction(Work $work)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity = new Order();
		$entity->setWork($work);
		$form  = $this->createForm(new OrderType(), $entity);
		return array(
				'entity' => $entity,
				'form'   => $form->createView()
		);
	}
	
	/**
	 * Creates a new Bill entity.
	 *
	 * @Route("/create", name="order_create")
	 * @Method("post")
	 * @Template("JLMOfficeBundle:Order:new.html.twig")
	 */
	public function createAction(Request $request)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity  = new Order();
		$form    = $this->createForm(new OrderType(), $entity);
		$form->handleRequest($request);
	
		if ($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			foreach ($entity->getLines() as $line)
			{
				$line->setOrder($entity);
				$em->persist($line);
			}
			$em->persist($entity);
			$work = $entity->getWork();
			$work->setOrder($entity);
			$em->persist($work);
			$em->flush();
			return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
		}
	
		return array(
		'entity' => $entity,
		'form'   => $form->createView()
		);
	}
	
	/**
	 * Displays a form to edit an existing Order entity.
	 *
	 * @Route("/{id}/edit", name="order_edit")
	 * @Template()
	 */
	public function editAction(Order $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		if ($entity->getState() > 2)
			return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
		$editForm = $this->createForm(new OrderType(), $entity);
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Edits an existing Order entity.
	 *
	 * @Route("/{id}/update", name="order_update")
	 * @Method("post")
	 * @Template("JLMOfficeBundle:Order:edit.html.twig")
	 */
	public function updateAction(Request $request, Order $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		// Si la commande est déjà validé, on empèche quelconque modification
		if ($entity->getState() > 2)
			return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
	
		$editForm = $this->createForm(new OrderType(), $entity);
		$editForm->handleRequest($request);
	
		if ($editForm->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			foreach ($entity->getLines() as $line)
			{
				$line->setOrder($entity);
				$em->persist($line);
			}
			$em->persist($entity);
			$em->flush();
			return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
		}
	
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Imprimer la fiche travaux
	 *
	 * @Route("/{id}/print", name="order_print")
	 */
	public function printAction(Order $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getId().'.pdf');
		$response->setContent($this->render('JLMOfficeBundle:Order:print.pdf.php',array('entity'=>array($entity))));
	
		//   return array('entity'=>$entity);
		return $response;
	}
	
	/**
	 * En préparation
	 * 
	 * @Route("/{id}/ordered", name="order_ordered")
	 */
	public function orderedAction(Order $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		if ($entity->getState() > 0)
			return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
		
		if ($entity->getState() < 1)
			$entity->setState(1);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
	}
	
	/**
	 * En préparation
	 *
	 * @Route("/{id}/ready", name="order_ready")
	 */
	public function readyAction(Order $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		if ($entity->getState() != 1)
			return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
	
		if ($entity->getState() < 2)
		{
			$entity->setState(2);
			$entity->setClose();
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
	}
	
	/**
	 * @Route("/todo", name="order_todo")
	 * @Template()
	 */
	public function todoAction()
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$em = $this->getDoctrine()->getManager();
		$list = $em->getRepository('JLMDailyBundle:Work')->getOrderTodo();
		return array('entities'=>$list);
	}
	
	/**
	 * Resultats de la barre de recherche.
	 *
	 * @Route("/search", name="order_search")
	 * @Method("post")
	 * @Template()
	 */
	public function searchAction(Request $request)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity = new Search;
		$form = $this->createForm(new SearchType(), $entity);
		$form->handleRequest($request);
		if ($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			return array(
					'layout'=> array('form_search_query'=>$entity),
					'entities' => $em->getRepository('JLMOfficeBundle:Order')->search($entity),
					'query' => $entity->getQuery(),
			);
		}
		return array('layout'=>array('form_search_query'=>$entity),'query' => $entity->getQuery(),);
	}
}