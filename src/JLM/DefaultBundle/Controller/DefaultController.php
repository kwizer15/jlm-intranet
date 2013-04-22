<?php

namespace JLM\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
    	// Stats Techs
		$em =$this->getDoctrine()->getManager();
		$shifts = $em->getRepository('JLMDailyBundle:ShiftTechnician')->getAll();
		$base = array(
				'fixing'=> 0,
				'work'=> 0,
				'maintenance'=> 0,
				'equipment'=> 0,
				'total'=> 0,
		);
		$numbers = $times = array('total'=>$base);
		foreach ($shifts as $shiftTech)
		{
			$type = $shiftTech->getTechnician().'';
			$tech = $shiftTech->getShifting()->getType();
			$time = $shiftTech->getTime();
			if (!isset($numbers[$type]))
			{
				$numbers[$type] = $base;
				$times[$type] = $base;
			}
			$numbers[$type][$tech]++;
			$numbers[$type]['total']++;
			$numbers['total'][$tech]++;
			$numbers['total']['total']++;
			$t = ($time === null) ? 0 : $time->format('%h')*60+$time->format('%i');
			$times[$type][$tech] += $t;
			$times[$type]['total'] += $t;
			$times['total'][$tech] += $t;
			$times['total']['total'] += $t;
		}
		foreach ($times as $key => $tech)
		{
			foreach($tech as $key2 => $type)
			{
				$times[$key][$key2] = new \DateInterval('PT'.round($type/60,0,PHP_ROUND_HALF_ODD).'H'.($type%60).'M');
			}
		}
		$repo = $em->getRepository('JLMDailyBundle:Maintenance');
		$maintenanceTotal = $repo->getCountTotal(false);
		$evolutionBaseDay = $maintenanceTotal / 182;
		$date1 = \DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 00:00:00');
		for ($i = 1; $i <= 182; $i++)
			$evolutionBase[$date1->getTimestamp()*1000] = $evolutionBaseDay*$i;
        return array(
        		'numbers'=>$numbers,
        		'times'=>$times,
        		'maintenanceDoes' => $repo->getCountDoes(false),
        		'maintenanceTotal' => $maintenanceTotal,
        		'evolution' => $repo->getCountDoesByDay(false),
        		'evolutionBase' => $evolutionBase,
        );
	}
	
	/**
	 * @Route("/info")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function infoAction()
	{
	
		phpinfo();exit;
	
		return array();
	}
}
