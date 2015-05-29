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
    	$em = $this->getDoctrine()->getManager();
    	$stats = array_merge(
    			$em->getRepository('JLMDailyBundle:ShiftTechnician')->getStatsByYear($year),
    			$em->getRepository('JLMDailyBundle:ShiftTechnician')->getStatsByMonths($year)
    	);

    	$numbers = $times = array();
    	for ($i = 1; $i <= 12; $i++)
    	{
    	    while (strlen($i) < 2)
    	    {
    	        $i = '0'.$i;
    	    }
    	    $d = new \DateTime($year.'-'.$i.'-01 00:00:00');
    	    $numbers[$d->format('F')] = $times[$d->format('F')] = array('total' => $base);
    	}
    	$numbers['Year'] = array('total' => $base);
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
    		$numbers[$period][$stat['name']][$stat['type']] = (int)$stat['number'];
    		$numbers[$period][$stat['name']]['total'] += (int)$stat['number'];
    		$numbers[$period]['total'][$stat['type']] += (int)$stat['number'];
    		$numbers[$period]['total']['total'] += (int)$stat['number'];
    		$times[$period][$stat['name']][$stat['type']] = (int)$stat['time'];
    		$times[$period][$stat['name']]['total'] += (int)$stat['time'];
    		$times[$period]['total'][$stat['type']] += (int)$stat['time'];
    		$times[$period]['total']['total'] += (int)$stat['time'];
    	}
    	foreach ($times as $period => $datas)
    	{
	    	foreach ($datas as $key => $tech)
	    	{
	    		foreach($tech as $key2 => $type)
	    		{
	    			$times[$period][$key][$key2] = new \DateInterval('PT'.round($type/60,0,PHP_ROUND_HALF_ODD).'H'.($type%60).'M');
	    		}
	    	}
    	}

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
    	
    	// @todo Into repsitory class
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
    	$results = $em->getRepository('JLMContractBundle:Contract')->getStatsByDates();
	   	$stats = array();
	   	foreach ($results as $result)
	   	{
	   		$d = new \DateTime($result['date']);
	   		$fd = $d->format('U')*1000;
	   		$stats[$fd] = array(
	   				'accession'=>array(
	   						'complete'=>0,
	   						'normal'=>0
	   						
	   				),'social'=>array('complete'=>0,'normal'=>0));
	   		
	   		if ($result['accession'])
	   		{
	   			if ($result['complete'])
	   			{
	   				$stats[$fd]['accession']['complete'] = $result['number'];
	   			}
	   			else
	   			{ 
	   				$stats[$fd]['accession']['normal'] = $result['number'];
	   			}
	   		}
	   		else
	   		{
	   			if ($result['complete'])
	   			{
	   				$stats[$fd]['social']['complete'] = $result['number'];
	   			}
	   			else
	   			{ 
	   				$stats[$fd]['social']['normal'] = $result['number'];
	   			}
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
    	$repo = $em->getRepository('JLMCommerceBundle:QuoteVariant');
    	
    	// @todo Into Repository class
    	$res = $repo->createQueryBuilder('a')
    		->where('a.state = 5')
    		->getQuery()->getResult();
    	$total = 0;
    	foreach($res as $r)
    	{
    		$total += $r->getTotalPrice();
    	}
    	$given = $total;
    	
    	// @todo Into Repository class
    	$res = $repo->createQueryBuilder('a')
    	            ->where('a.state > 2')
    	            ->getQuery()->getResult();
    	$total = 0;
    	foreach($res as $r)
    	{
    		$total += $r->getTotalPrice();
    	}
    	
    	return array('given' => $given, 'total' => $total);
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
    		{
    			$datas[$stat['year']] = $base;
    		}
    		$datas[$stat['year']][$stat['month']] = $stat['number'];
    	}
    	
    	return array('stats'=>$datas);
    }
    
    /**
     * @Route("/sells", name="state_sells")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function sellsAction()
    {
    	$year = $this->getRequest()->get('year',null);
    	$em = $this->getDoctrine()->getManager();
    	$stats = $em->getRepository('JLMCommerceBundle:Bill')->getSells($year);
    	$total = 0;
    	foreach ($stats as $key => $stat)
    	{
    		$total += $stat['total'];
			$stats[$key]['pu'] = ($stat['qty'] == 0) ? 0 : ($stat['total'] / $stat['qty']);
    	}
    	 
    	return array('stats'=>$stats, 'total'=>$total);
    }
    
    /**
     * @Route("/lastbill", name="state_lastbill")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function lastbillAction()
    {
    	$manager = $this->get('jlm_commerce.bill_manager');
		$manager->secure('ROLE_USER');
		$datas = array();
		$datas['entities'] = $manager->getRepository()->get45Sended();
		$datas['ca'] = 0;
		foreach($datas['entities'] as $entity)
		{
			$datas['ca'] += $entity->getTotalPrice();
		}
		return $manager->renderResponse('JLMStateBundle:Default:lastbill.html.twig',
				$datas
		);
    }
    
    /**
     * @Route("/doortypes", name="state_doortypes")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function doortypesAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$doors = $em->getRepository('JLMModelBundle:Door')->getCountByType();
    	$intervs = $em->getRepository('JLMModelBundle:Door')->getCountIntervsByType();
    	$tot = $totinter = 0;
    	$data = array();
		foreach ($doors as $door)
		{
			foreach ($intervs as $interv)
			{
				if ($door['name'] == $interv['name'])
				{
					$data[$door['name']] = array('nb' => $door['nb'], 'intervs' => $interv['nb'], 'moyintervs' => $interv['nb'] / $door['nb']);
					$tot += $door['nb'];
					$totinter += $interv['nb'];
				}
			}
		}
		
    	return array('datas' => $data, 'tot'=>$tot, 'totinter'=>$totinter, 'moytot' => $totinter / $tot);
    }

}
