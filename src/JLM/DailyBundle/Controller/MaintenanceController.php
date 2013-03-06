<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Maintenance;
use JLM\DailyBundle\Entity\ShiftTechnician;
use JLM\DailyBundle\Form\Type\AddTechnicianType;
use JLM\DailyBundle\Form\Type\MaintenanceCloseType;
use JLM\ModelBundle\Entity\Door;

/**
 * Maintenance controller.
 *
 * @Route("/maintenance")
 */
class MaintenanceController extends Controller
{
	/**
	 * Finds and displays a InterventionPlanned entity.
	 *
	 * @Route("/list", name="maintenance_list")
	 * @Route("/list/{page}", name="maintenance_list_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listAction($page = 1)
	{
		
		$limit = 15;
		$em = $this->getDoctrine()->getEntityManager();
		$nb = $em->getRepository('JLMDailyBundle:Maintenance')->getCountOpened();
		$nbPages = ceil($nb/$limit);
		$nbPages = ($nbPages < 1) ? 1 : $nbPages;
		$offset = ($page-1) * $limit;
		if ($page < 1 || $page > $nbPages)
		{
			throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
		}
		

		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('JLMDailyBundle:Maintenance')->getPrioritary($limit,$offset);
		return array(
				'entities'      => $entities,
				'page'     => $page,
				'nbPages'  => $nbPages,
		);
	}
	
	/**
	 * Finds and displays a Maintenance entity.
	 *
	 * @Route("/{id}/show", name="maintenance_show")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction(Maintenance $entity)
	{
		$st = new ShiftTechnician();
		$st->setBegin(new \DateTime);
		$form   = $this->createForm(new AddTechnicianType(), $st);
		
		return array(
				'entity' => $entity,
				'form_newtech'   => $form->createView(),
		);
	}
	
	/**
	 * Close an existing Fixing entity.
	 *
	 * @Route("/{id}/close", name="maintenance_close")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function closeAction(Maintenance $entity)
	{
		$form = $this->createForm(new MaintenanceCloseType(), $entity);
	
		return array(
				'entity'      => $entity,
				'form'   => $form->createView(),
		);
	}
	
	/**
	 * Close an existing Maintenance entity.
	 *
	 * @Route("/{id}/closeupdate", name="maintenance_closeupdate")
	 * @Method("POST")
	 * @Template("JLMDailyBundle:Maintenance:close.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function closeupdateAction(Request $request, Maintenance $entity)
	{
		$em = $this->getDoctrine()->getManager();
			
		$form = $this->createForm(new MaintenanceCloseType(), $entity);
		$form->bind($request);
	
		if ($form->isValid())
		{
			$entity->setClose(new \DateTime);
			$em->persist($entity);
			$em->flush();
			return $this->redirect($this->generateUrl('maintenance_show', array('id' => $entity->getId())));
		}
	
		return array(
				'entity'      => $entity,
				'form'   => $form->createView(),
		);
	}
	
	/**
	 * Creation des entretiens a faire
	 *
	 * @Route("/scan", name="maintenance_scan")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function scanAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$doors = $em->getRepository('JLMModelBundle:Door')->findAll();
		foreach ($doors as $door)
		{
			if ($em->getRepository('JLMDailyBundle:Maintenance')->isPlanned($door))
			{
				
			}
		}
	}
	
	/**
	 * Creation des entretiens a faire
	 *
	 * @Route("/generate/{id}", name="maintenance_generate")
	 * @Secure(roles="ROLE_USER")
	 */
	public function generateAction(Door $door)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$other = $em->getRepository('JLMDailyBundle:Maintenance')->findOneByDoor($door);
		if ($other === null)
		{
			$main = new Maintenance;
			$main->setCreation(new \DateTime);
			$main->setPlace($door.'');
			$main->setReason('Visite d\'entretien');
			$main->setContract($door->getActualContract());
			$main->setDoor($door);
			$main->setPriority(5);
			
		
			$em->persist($main);
			$em->flush();
			
			$id = $main->getId();
		}
		else
			$id = $other->getId();
		return $this->redirect($this->generateUrl('maintenance_show', array('id' => $id)));
	}
}
