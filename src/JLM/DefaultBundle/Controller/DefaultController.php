<?php

namespace JLM\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Door;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="default")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
    	// Stats Techs
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
		$repo = $em->getRepository('JLMDailyBundle:Maintenance');
		$maintenanceTotal = $repo->getCountTotal(false);
		$evolutionBaseDay = $maintenanceTotal / 182;
		$date1 = \DateTime::createFromFormat('Y-m-d H:i:s','2013-01-01 00:00:00');
		$now = new \DateTime;
		for ($i = 1; $i <= 182 && $date1 < $now  ; $i++)
		{
			$evolutionBase[$date1->getTimestamp()*1000] = (int)($maintenanceTotal*($i / 182));
			$date1->add(new \DateInterval('P1D'));
		}
		// Nombre de contrats en cours
		$repocon = $em->getRepository('JLMModelBundle:Contract');
		$contracts_numbers = $repocon
			->createQueryBuilder('a')
			->select('COUNT(DISTINCT a.number)')
			->where('?1 BETWEEN a.begin AND a.end')
			->orWhere('a.end IS NULL')
			->setParameter(1,new \DateTime)
			->getQuery()
			->getSingleScalarResult();
		$contracts_doors = $repocon
			->createQueryBuilder('a')
			->select('COUNT(DISTINCT a.door)')
			->where('?1 BETWEEN a.begin AND a.end')
			->orWhere('a.end IS NULL')
			->setParameter(1,new \DateTime)
			->getQuery()
			->getSingleScalarResult();
		$contracts_complete = $repocon
			->createQueryBuilder('a')
			->select('COUNT(DISTINCT a.door)')
			->where('?1 BETWEEN a.begin AND a.end AND a.complete = 1')
			->orWhere('a.end IS NULL AND a.complete = 1')
			->setParameter(1,new \DateTime)
			->getQuery()
			->getSingleScalarResult();
        return array(
        		'numbers'=>$numbers,
        		'times'=>$times,
        		'maintenanceDoes' => $repo->getCountDoes(false),
        		'maintenanceTotal' => $maintenanceTotal,
        		'evolution' => $repo->getCountDoesByDay(false),
        		'evolutionBase' => $evolutionBase,
        		'contracts_numbers' => $contracts_numbers,
        		'contracts_doors' => $contracts_doors,
        		'contracts_complete' => $contracts_complete,
        		'contracts_normal' => ($contracts_doors - $contracts_complete),
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
	
	/**
	 * @Route("/robot.txt")
	 * @Template("JLMDefaultBundle:Default:robot.txt.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function robotAction()
	{
		return array();
	}
	
	/**
	 * @Route("/installation/{code}")
	 * @Template()
	 */
	public function installationAction($code)
	{
		$em = $this->getDoctrine()->getManager();
		
		$entity = $em->getRepository('JLMModelBundle:Door')->getByCode($code);
		if ($entity === null)
		{
			throw $this->createNotFoundException('Cette installation n\'existe pas');
		}
		
		return array('door'=>$entity);
	}
	
	/**
	 * @Route("/printtags")
	 * @Route("/printtag/{code}")
	 */
	public function printtagAction($code = null)
	{
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('JLMModelBundle:Door');
		if ($code === null)
		{
			$nb = 0;
			$codes = array();
			$lettres = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
			while ($nb < 100)
			{
				// On genèree un code aléatoire
				$newCode = rand(100,999).$lettres[rand(0,24)].rand(0,999);
				// On vérifie s'il n'existe pas en BDD
				$door = $repo->getByCode($newCode);
				if ($door === null && !in_array($newCode,$codes))
				{
					$codes[] = $newCode;
					$nb++;
				}
			}
		}
		else
		{
			$codes = array($code);
		}
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename=tags.pdf');
		$out = \JLM\DefaultBundle\Pdf\Tag::get($codes);
		$response->setContent($out);
		
		return $response;

	}
}
