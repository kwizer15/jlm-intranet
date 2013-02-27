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
	 * @Route("/page/{page}/type/{type}", name="task_type")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction($page = 1, $type = null)
	{
		$limit = 10;
		$em = $this->getDoctrine()->getEntityManager();
		 
		$nb = $em->getRepository('JLMOfficeBundle:Task')->getCountOpened($type);
		$nbPages = ceil($nb/$limit);
		$nbPages = ($nbPages < 1) ? 1 : $nbPages;
		$offset = ($page-1) * $limit;
		if ($page < 1 || $page > $nbPages)
		{
			throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
		}
	
		$entities = $em->getRepository('JLMOfficeBundle:Task')->getOpened(
				$type,
				$limit,
				$offset
		);
	
		return array(
				'entities' => $entities,
				'page'     => $page,
				'nbPages'  => $nbPages,
				'type' => $type
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
		// Commander materiel -> on crée les travaux
/*		if ($entity->getType()->getId() == 3)
		{
			if (preg_match('#quote/variant/([0-9]+)/print#',$entity->getUrlSource(),$matches))
				return $this->redirect($this->generateUrl('work_new_quote',array('id'=>$matches[1])));
			return $this->redirect($this->generateUrl('work_new_door',array('id'=>$entity->getDoor()->getId())));
		}
*/		return $this->redirect($this->generateUrl('task'));
	}
	
	/**
	 * Sidebar
	 * @Route("/sidebar", name="task_sidebar")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function sidebarAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		
		return array(
				'all' => $em->getRepository('JLMOfficeBundle:Task')->getCountOpened(),
				'quotes' => $em->getRepository('JLMOfficeBundle:Task')->getCountOpened(2),
				'orders' => $em->getRepository('JLMOfficeBundle:Task')->getCountOpened(3),
				'bills' => $em->getRepository('JLMOfficeBundle:Task')->getCountOpened(1),
				'contacts' => $em->getRepository('JLMOfficeBundle:Task')->getCountOpened(4),
			);
	}
}
