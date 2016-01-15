<?php

namespace JLM\StateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Default controller.
 */
class DefaultController extends Controller
{
    /**
     * @Route("/technicians/", name="state_technicians")
     * @Route("/technicians/{year}", name="state_technicians_year")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
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
	    			$h = abs(round($type/60,0,PHP_ROUND_HALF_ODD));
	    			$m = abs($type%60);
	    			$times[$period][$key][$key2] = new \DateInterval('PT'.$h.'H'.$m.'M');
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
     * @Secure(roles="ROLE_OFFICE")
     */
    public function maintenanceAction()
    {
    	$em =$this->getDoctrine()->getManager();
    	$repo = $em->getRepository('JLMDailyBundle:Maintenance');
    	$maintenanceTotal = $repo->getCountTotal(false);
    	$now = new \DateTime;
    	$date1 = \DateTime::createFromFormat('Y-m-d H:i:s',$now->format('Y').'-01-01 00:00:00');
    	
    	$evolutionBase = array();
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
     * @Secure(roles="ROLE_OFFICE")
     */
    public function topAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repo = $em->getRepository('JLMDailyBundle:Fixing');
    	$date = new \DateTime();
    	
    	return array('results' => $repo->getTop50($date->format('Y').'-01-01'));
    }
    
    /**
     * @Route("/contracts", name="state_contracts")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function contractsAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$results = $em->getRepository('JLMContractBundle:Contract')->getStatsByMonth();
	   	$stats = array();
	   	foreach ($results as $result)
	   	{
	   		if (!isset($stats[$result['year']][$result['month']]))
	   		{
		   		$stats[$result['year']][$result['month']] = 0;
	   		}
	   		$stats[$result['year']][$result['month']] = $result['number'];
	   	}
    	return array('stats'=> $stats);
    }
    
    /**
     * @Route("/quote", name="state_quote")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function quoteAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repo = $em->getRepository('JLMCommerceBundle:QuoteVariant');
    	$add = function($carry, $item){ return $carry + $item->getTotalPrice(); };
    	
    	return array(
    			'given' => array_reduce($repo->getCountGiven(), $add, 0),
    			'total' => array_reduce($repo->getCountSended(), $add, 0)
    	);
    }
    
    /**
     * @Route("/transmitters", name="state_transmitters")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function transmittersAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$stats = $em->getRepository('JLMTransmitterBundle:Transmitter')->getStatsByMonth();
    	$datas = [];
    	$byYear = [];
    	foreach ($stats as $stat)
    	{
    		if (!isset($datas[$stat['year']]))
    		{
    			$datas[$stat['year']] = array_fill(1,12,0);
    			$byYear[$stat['year']] = 0;
    			
    		}
    		$datas[$stat['year']][$stat['month']] = $stat['number'];
    		$byYear[$stat['year']] += $stat['number'];
    	}
    	
    	return array('stats'=>$datas, 'byYear' => $byYear);
    }
    
    /**
     * @Route("/sells", name="state_sells")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
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
     * @Route("/daybill", name="state_daybill")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function daybillAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$stats = $em->getRepository('JLMCommerceBundle:Bill')->getDayBill();
    	$datas = array();
    	foreach ($stats as $stat)
    	{
    		$key = $stat->getCreation()->format('d/m/Y');
    		if (!isset($datas[$key]))
    		{
    			$datas[$key] = array('bills' => array(), 'amount' => 0);
    		}
    		$datas[$key]['bills'][] = $stat;
    		$datas[$key]['amount'] += $stat->getTotalPrice();
    	}
    	return array('datas'=>$datas);
    }
    
    /**
     * @Route("/lastbill", name="state_lastbill")
     * @Template()
     */
    public function lastbillAction()
    {
    	$manager = $this->get('jlm_commerce.bill_manager');
		$manager->secure('ROLE_OFFICE');
		$entities = $manager->getRepository()->get45Sended();

		return $manager->renderResponse('JLMStateBundle:Default:lastbill.html.twig',
				array('entities' => $entities,
					  'ca' => array_reduce($entities, function($carry, $item) { return $carry + $item->getTotalPrice(); }, 0),
					  'title' => 'Factures en cours',
					)
				);
    }
    
    /**
     * @Route("/latebill", name="state_latebill")
     * @Template()
     */
    public function latebillAction()
    {
    	$manager = $this->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_OFFICE');
    	$entities = $manager->getRepository()->getSendedMore45();
    
    	return $manager->renderResponse('JLMStateBundle:Default:lastbill.html.twig',
    			array('entities' => $entities,
    					'ca' =>array_reduce($entities, function($carry, $item) { return $carry + $item->getTotalPrice(); }, 0),
    					'title' => 'Factures à 45 jours et plus',
    			)
    	);
    }
    
    /**
     * @Route("/doortypes/{year}", name="state_doortypes")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function doortypesAction($year = null)
    {
    	$date = new \DateTime();
    	$maxyear = $date->format('Y');
    	$year = ($year === null) ? $maxyear : $year;
    	$em = $this->getDoctrine()->getManager();
    	$repo = $em->getRepository('JLMModelBundle:Door');
    	$doors = $repo->getCountByType($year);
    	$intervs = $repo->getCountIntervsByType($year);
    	$complets = $repo->getCountIntervsByTypeAndContract(array('C1','C2'),$year);
    	$normaux = $repo->getCountIntervsByTypeAndContract(array('N3','N4'),$year);
    	$hc = $repo->getCountIntervsByTypeAndContract(array('HC','Hors contrat'),$year);
    	$tot = $totinter = $tottime = 0;
    	$total = array('C'=>0,'N'=>0,'HC'=>0);
    	$data = array();
		foreach ($doors as $door)
		{
			$data[$door['name']] = array(
					'nb' => (int)$door['nb'],
					'intervs' => 0,
					'intC' => 0,
					'intN' => 0,
					'intHC' => 0,
					'moyintervs' => 0,
					'time' => new \DateInterval('PT0S'),
					'moytime' => new \DateInterval('PT0S'),
			);
			$tot += $door['nb'];
			foreach ($intervs as $interv)
			{
				if ($door['name'] == $interv['name'])
				{
					$data[$door['name']]['intervs'] = (int)$interv['nb'];
					$data[$door['name']]['moyintervs'] = (float)($interv['nb'] / $door['nb']);
					$data[$door['name']]['time'] = $this->secondsToInterval($interv['time']);
					$data[$door['name']]['moytime'] = $this->secondsToInterval($interv['time']/$door['nb']);
					
					$totinter += $interv['nb'];
					$tottime += $interv['time'];
				}
			}
			foreach (array('C'=> $complets, 'N'=>$normaux, 'HC'=>$hc ) as $type => $contracts)
			{
				foreach ($contracts as $interv)
				{
					if ($door['name'] == $interv['name'])
					{
						$data[$door['name']]['int'.$type] = (int)$interv['nb'];
						$total[$type] += $interv['nb'];
					}
				}
			}
		}
		
    	return array(
    			'datas' => $data,
    			'tot'=>$tot,
    			'totinter'=>$totinter,
    			'tottime' => $this->secondsToInterval($tottime),
    			'moytot' => (float)($totinter / $tot),
    			'moytime' => $this->secondsToInterval($tottime/$tot),
    			'year' => $year,
    			'maxyear' => $maxyear,
    			'totC' => $total['C'],
    			'totN' => $total['N'],
    			'totHC' => $total['HC'],
    	);
    }

    private function secondsToInterval($seconds)
    {
    	$seconds = floor($seconds);
    	$hours = floor($seconds / 3600);
    	$minutes = floor($seconds / 60) - $hours * 60;
    	
    	return new \DateInterval('PT'.$hours.'H'.$minutes.'M');
    }
    
    /**
     * @Route("/quotes/{year}", name="state_quotes")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function quotesAction($year = null)
    {
    	$date = new \DateTime();
    	$maxyear = $date->format('Y');
    	$year = ($year === null) ? $maxyear : $year;
    	$repo = $this->getDoctrine()->getManager()->getRepository('JLMCommerceBundle:Quote');
    	
    	return array(
    			'sends' => $repo->getSends($year),
    			'givens'=> $repo->getGivens($year),
    			'year' => $year,
    			'maxyear' => $maxyear,
    	);
    }
}
