<?php

namespace JLM\StateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Default controller.
 *
 * @Route("/state")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/technicians", name="state_technicians")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function techniciansAction()
    {
    	$em =$this->getDoctrine()->getManager();
    	$stats = $em->getRepository('JLMDailyBundle:ShiftTechnician')->getStatsByYear();
    	$base = array(
    			'fixing'=> 0,
    			'work'=> 0,
    			'maintenance'=> 0,
    			'equipment'=> 0,
    			'total'=> 0,
    	);
    	$numbers = $times = array('total'=>$base);
    	foreach ($stats as $stat)
    	{
    		if (!isset($numbers[$stat['name']]))
    		{
    			$numbers[$stat['name']] = $base;
    			$times[$stat['name']] = $base;
    		}
    		$numbers[$stat['name']][$stat['type']] = $stat['number'];
    		$numbers[$stat['name']]['total'] += $stat['number'];
    		$numbers['total'][$stat['type']] += $stat['number'];
    		$numbers['total']['total'] += $stat['number'];
    		$times[$stat['name']][$stat['type']] = $stat['time'];
    		$times[$stat['name']]['total'] += $stat['time'];
    		$times['total'][$stat['type']] += $stat['time'];
    		$times['total']['total'] += $stat['time'];
    	}
    	foreach ($times as $key => $tech)
    	{
    		foreach($tech as $key2 => $type)
    		{
    			$times[$key][$key2] = new \DateInterval('PT'.round($type/60,0,PHP_ROUND_HALF_ODD).'H'.($type%60).'M');
    		}
    	}
    	return array(
    			'numbers'=>$numbers,
    			'times'=>$times,
    	);
    }
    
    /**
     * @Route("/maintenance", name="state_maintenance")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function maintenanceAction()
    {
    	$em =$this->getDoctrine()->getManager();
    	$repo = $em->getRepository('JLMDailyBundle:Maintenance');
    	$maintenanceTotal = $repo->getCountTotal(false);
    	$date1 = \DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 00:00:00');
    	$now = new \DateTime;
    	for ($i = 1; $i <= 182 && $date1 < $now  ; $i++)
    	{
	    	$evolutionBase[$date1->getTimestamp()*1000] = (int)($maintenanceTotal*($i/182));
	    	$date1->add(new \DateInterval('P1D'));
		}
    	return array(
    			'maintenanceDoes' => $repo->getCountDoes(false),
    			'maintenanceTotal' => $maintenanceTotal,
    			'evolution' => $repo->getCountDoesByDay(false),
    			'evolutionBase' => $evolutionBase,
    		);
    }
    
    /**
     * @Route("/top", name="state_top")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function topAction()
    {
    	$em =$this->getDoctrine()->getManager();
    	$repo = $em->getRepository('JLMDailyBundle:Fixing');
    	$result = $repo->createQueryBuilder('a')
    		->select('b.id, f.name as type, b.location, d.street, e.name as city, e.zip, g.begin,  COUNT(g) as nb')
    		->leftJoin('a.door','b')
    		->leftJoin('b.site','c')
    		->leftJoin('c.address','d')
    		->leftJoin('d.city','e')
    		->leftJoin('b.type','f')
    		->leftJoin('a.shiftTechnicians','g')
    		->orderBy('nb','desc')
    		->addOrderBy('g.begin','desc')
    		->where('g.begin > ?1')
    		->groupBy('b')
    		->setParameter(1,'2013-01-01')
    		->setMaxResults(50)
    		->getQuery()
    		->getResult();
    	;
    	return array('results' => $result);
    }
}
