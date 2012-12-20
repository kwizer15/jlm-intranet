<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Technician;
use JLM\DailyBundle\Entity\Shifting;
use JLM\DailyBundle\Entity\ShiftTechnician;
use JLM\DailyBundle\Form\Type\AddTechnicianType;

/**
 * Fixing controller.
 *
 * @Route("/shifting")
 */
class ShiftingController extends Controller
{
	/**
	 * List
	 * @Route("/list/{id}", name="shifting_list")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function listAction(Technician $technician)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$shiftings = $em->getRepository('JLMDailyBundle:ShiftTechnician')->findByTechnician($technician,array('creation'=>'desc'));
		return array(
				'technician'=>$technician,
				'shiftings' => $shiftings
		);
	}
	
	/**
	 * Ajoute un technicien sur une intervention
	 * @Route("/new/{id}", name="shifting_new")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function newAction(Shifting $shifting)
	{
		$entity = new ShiftTechnician();
		$entity->setBegin(new \DateTime);
		$form   = $this->createForm(new AddTechnicianType(), $entity);
		
		return array(
				'shifting' => $shifting,
				'entity' => $entity,
				'form'   => $form->createView(),
		);
	}
	
	/**
	 * Creates a new ShiftTechnician entity.
	 *
	 * @Route("/create/{id}", name="shifting_create")
	 * @Method("POST")
	 * @Template("JLMDailyBundle:Shifting:new.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function createAction(Request $request, Shifting $shifting)
	{
		$entity  = new ShiftTechnician();
		$form = $this->createForm(new AddTechnicianType(), $entity);
		$form->bind($request);
	
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity->setCreation(new \DateTime);
			$entity->setShifting($shifting);
			$em->persist($shifting);
			$em->persist($entity);
			$em->flush();
	
			return $this->redirect($this->generateUrl('daily'));
		}
	
		return array(
				'entity' => $entity,
				'form'   => $form->createView(),
		);
	}
}