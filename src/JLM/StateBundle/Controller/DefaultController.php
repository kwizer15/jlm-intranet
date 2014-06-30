<?php

namespace JLM\StateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Default controller.
 */
class DefaultController extends Controller
{
    /**
     * @Route("/technicians/", name="state_technicians")
     * @Route("/technicians/{year}", name="state_technicians_year")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function techniciansAction($year = null)
    {
		// Initialisation des tableaux
		$date = new \DateTime;
		$year = ($year === null) ? $date->format('Y') : $year;
    	$base = array(
    			'fixing'=> 0,
    			'work'=> 0,
    			'maintenance'=> 0,
    			'equipment'=> 0,
    			'total'=> 0,
    	);
    	$em =$this->getDoctrine()->getManager();
    	$stats = array_merge(
    			$em->getRepository('JLMDailyBundle:ShiftTechnician')->getStatsByYear($year),
    			$em->getRepository('JLMDailyBundle:ShiftTechnician')->getStatsByMonths($year)
    	);
    	$numbers = array();
    	for ($i = 1; $i <= 12; $i++)
    	{
    	    while (strlen($i) < 2)
    	    {
    	        $i = '0'.$i;
    	    }
    	    $d = new \DateTime('2013-'.$i.'-01 00:00:00');
    	    $numbers[$d->format('F')] = $times[$d->format('F')] = array('total'=>$base);
    	}
    	$numbers['Year'] = array('total'=>$base);
    	$times = $numbers;
    	foreach ($stats as $stat)
    	{
    		$period = 'Year';
    		if (isset($stat['month']))
    		{
    			$d = new \DateTime($year.'-'.$stat['month'].'-01 00:00:00');
    			$period = $d->format('F');
    		}
    		if (!isset($numbers[$period][$stat['name']]))
    		{
    			$numbers[$period][$stat['name']] = $base;
    			$times[$period][$stat['name']] = $base;
    		}
    		$numbers[$period][$stat['name']][$stat['type']] = $stat['number'];
    		$numbers[$period][$stat['name']]['total'] += $stat['number'];
    		$numbers[$period]['total'][$stat['type']] += $stat['number'];
    		$numbers[$period]['total']['total'] += $stat['number'];
    		$times[$period][$stat['name']][$stat['type']] = $stat['time'];
    		$times[$period][$stat['name']]['total'] += $stat['time'];
    		$times[$period]['total'][$stat['type']] += $stat['time'];
    		$times[$period]['total']['total'] += $stat['time'];
    	}
    	foreach ($times as $period => $datas)
	    	foreach ($datas as $key => $tech)
	    		foreach($tech as $key2 => $type)
	    			$times[$period][$key][$key2] = new \DateInterval('PT'.round($type/60,0,PHP_ROUND_HALF_ODD).'H'.($type%60).'M');

    	return array(
    			'year' => $year,
    			'numbers' => $numbers,
    			'times' => $times,
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
    	for ($i = 1; $i <= 365 && $date1 < $now  ; $i++)
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
    	$em = $this->getDoctrine()->getManager();
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
    
    /**
     * @Route("/contracts", name="state_contracts")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function contractsAction()
    {
    	
    	$em = $this->getDoctrine()->getManager();
    	$results = $em->getRepository('JLMModelBundle:Contract')->getStatsByDates();
	   	$stats = array();
	   	foreach ($results as $result)
	   	{
	   		$d = new \DateTime($result['date']);
	   		if ($result['accession'] == 1)
	   		{
	   			if ($result['complete'] == 1)
	   				$stats[$d->format('U')*1000]['accession']['complete'] = $result['number'];
	   			else 
	   				$stats[$d->format('U')*1000]['accession']['normal'] = $result['number'];
	   		}
	   		else
	   		{
	   			if ($result['complete'] == 1)
	   				$stats[$d->format('U')*1000]['social']['complete'] = $result['number'];
	   			else 
	   				$stats[$d->format('U')*1000]['social']['normal'] = $result['number'];
	   		}
	   	}
	   	
    	return array(
    			'stats'=> $stats,
    			
    	);
    }
    
    /**
     * @Route("/quote", name="state_quote")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function quoteAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repo = $em->getRepository('JLMOfficeBundle:QuoteVariant');
    	$res = $repo->createQueryBuilder('a')
    		->where('a.state = 5')
    		->getQuery()->getResult();
    	$total = 0;
    	foreach($res as $r)
    	{
    		$total += $r->getTotalPrice();
    	}
    	echo $total.'<br>';
    	$res = $repo->createQueryBuilder('a')
    	->where('a.state > 2')
    	->getQuery()->getResult();
    	$total = 0;
    	foreach($res as $r)
    	{
    		$total += $r->getTotalPrice();
    	}
    	echo $total; exit;
    }
    
    /**
     * @Route("/transmitters", name="state_transmitters")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function transmittersAction()
    {
    	$base = array(1=>0,0,0,0,0,0,0,0,0,0,0,0);
    	$em = $this->getDoctrine()->getManager();
    	$stats = $em->getRepository('JLMTransmitterBundle:Transmitter')->getStatsByMonth();
    	$datas = array();
    	foreach ($stats as $stat)
    	{
    		if (!isset($datas[$stat['year']]))
    			$datas[$stat['year']] = $base;
    		$datas[$stat['year']][$stat['month']] = $stat['number'];
    	}
    	return array('stats'=>$datas);
    }
}
