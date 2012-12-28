<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\OfficeBundle\Entity\Task;

/**
 * Task controller.
 *
 * @Route("/task")
 */
class TaskController extends Controller
{
	/**
	 * Lists all Quote entities.
	 *
	 * @Route("/", name="task")
	 * @Route("/page/{page}", name="task_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction($page = 1)
	{
		$limit = 10;
		$em = $this->getDoctrine()->getEntityManager();
		 
		$nb = $em->getRepository('JLMOfficeBundle:Task')->getCountOpened();
		$nbPages = ceil($nb/$limit);
		$nbPages = ($nbPages < 1) ? 1 : $nbPages;
		$offset = ($page-1) * $limit;
		if ($page < 1 || $page > $nbPages)
		{
			throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
		}
	
		$entities = $em->getRepository('JLMOfficeBundle:Task')->findBy(
				array('close'=>null),
				array('open'=>'asc'),
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
	 * Close a task
	 * @Route("/{id}/close", name="task_close")
	 * @Secure(roles="ROLE_USER")
	 */
	public function closeAction(Task $entity)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$entity->setClose(new \DateTime);
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('task'));
	}
}
