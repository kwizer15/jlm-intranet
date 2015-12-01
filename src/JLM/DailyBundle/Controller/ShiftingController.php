<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Technician;
use JLM\DailyBundle\Entity\Shifting;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Entity\ShiftTechnician;
use JLM\DailyBundle\Form\Type\AddTechnicianType;
use JLM\DailyBundle\Form\Type\ShiftingEditType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Fixing controller.
 */
class ShiftingController extends Controller
{
	/**
	 * List
	 * @Secure(roles="ROLE_OFFICE")
	 * @Template()
	 */
	public function listAction(Technician $technician, $page = 1)
	{
		$limit = 10;
		$em = $this->getDoctrine()->getManager();
			
		$nb = $em->getRepository('JLMDailyBundle:ShiftTechnician')->getCountWithoutTime($technician);
		$nbPages = ceil($nb/$limit);
		$nbPages = ($nbPages < 1) ? 1 : $nbPages;
		$offset = ($page-1) * $limit;
		if ($page < 1 || $page > $nbPages)
		{
			throw $this->createNotFoundException('Page inexistante (page '.$page.'/'.$nbPages.')');
		}
		$entities = $em->getRepository('JLMDailyBundle:ShiftTechnician')->getWithoutTime($technician,$limit,
				$offset);
		
		return array(
				'technician'=>$technician,
				'shiftings' => $entities,
				'page'     => $page,
				'nbPages'  => $nbPages,
		);
	}
	
	/**
	 * Ajoute un technicien sur une intervention
	 * @Secure(roles="ROLE_OFFICE")
	 * @Template()
	 */
	public function newAction(Shifting $shifting)
	{
		$entity = new ShiftTechnician();
		
		$entity->setBegin(new \DateTime);
		$form = $this->get('form.factory')->createNamed('shiftTechNew'.$shifting->getId(),new AddTechnicianType(), $entity);
				
		return array(
				'shifting' => $shifting,
				'entity' => $entity,
				'form'   => $form->createView(),
				'id' => $shifting->getId(),
		);
	}
	
	/**
	 * Creates a new ShiftTechnician entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function createAction(Request $request, Shifting $shifting)
	{
		$entity  = new ShiftTechnician();
		$entity->setShifting($shifting);
		$entity->setCreation(new \DateTime);
		$form = $this->get('form.factory')->createNamed('shiftTechNew'.$shifting->getId(),new AddTechnicianType(), $entity);
		$form->bind($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($shifting);
			$em->persist($entity);
			$em->flush();
	
			if ($request->isXmlHttpRequest())
			{
				return new JsonResponse(array());
			}
			return $this->redirect($request->headers->get('referer'));
		}
	
		return array(
				'shifting'=>$shifting,
				'entity' => $entity,
				'form'   => $form->createView(),
		);
	}
	
	/**
	 * Displays a form to edit an existing ShiftTechnician entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function editAction(ShiftTechnician $entity)
	{
		$editForm = $this->get('form.factory')->createNamed('shiftTechEdit'.$entity->getId(),new ShiftingEditType(), $entity);
		return array(
				'entity'      => $entity,
				'form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Displays a form to edit an existing ShiftTechnician entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 * @deprecated Modal system
	 */
	public function edittableAction(ShiftTechnician $entity)
	{
		return $this->editAction($entity);
	}
	
	/**
	 * Edits an existing InterventionPlanned entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function updateAction(Request $request, ShiftTechnician $entity)
	{
		$em = $this->getDoctrine()->getManager();
		$editForm = $this->get('form.factory')->createNamed('shiftTechEdit'.$entity->getId(),new ShiftingEditType(), $entity);
		$editForm->bind($request);
	
		if ($editForm->isValid())
		{
			$begin = $entity->getBegin();
			$end = $entity->getEnd();
			if ($end->format('Hi') != '0000')
			{
				$end->setDate($begin->format('Y'),$begin->format('m'),$begin->format('d'));
				$entity->setEnd($end);
			}
			else
			{
				$entity->setEnd();
			}
			$em->persist($entity);
			$em->flush();

			return $request->isXmlHttpRequest() ? new JsonResponse(array()) : $this->redirect($request->headers->get('referer'));
		}
	
		return array(
				'entity'      => $entity,
				'form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Delete an existing ShiftTechnician entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function deleteAction(ShiftTechnician $entity)
	{
		$intervId = $entity->getShifting()->getId();
		$em = $this->getDoctrine()->getManager();
		$em->remove($entity);
		$em->flush();
	
		return $this->redirect($this->generateUrl('intervention_redirect', array('id' => $intervId, 'act'=>'show')));
	}
}