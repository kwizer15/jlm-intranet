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


class ShiftingController extends Controller
{
	/**
	 * Search
	 * @Route("/shifting/list/{id}", name="shifting_list")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function listAction(Technician $technician)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$shiftings = $em->getRepository('JLMDailyBundle:ShiftTechnician')->findByTechnician($technician,array('creation'=>'desc'),10);
		return array(
				'technician'=>$technician,
				'shiftings' => $shiftings
		);
	}
}