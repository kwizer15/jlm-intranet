<?php

namespace JLM\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route(path="/",name="default")
     * @Template()
     */
    public function indexAction(): array
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        // Stats Techs
        $em =$this->getDoctrine()->getManager();
        $stats = $em->getRepository('JLMDailyBundle:ShiftTechnician')->getStatsByYear();
        $base = [
                 'fixing'      => 0,
                 'work'        => 0,
                 'maintenance' => 0,
                 'equipment'   => 0,
                 'total'       => 0,
                ];
        $numbers = $times = ['total' => $base];
        foreach ($stats as $stat) {
            if (!isset($numbers[$stat['name']])) {
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
        foreach ($times as $key => $tech) {
            foreach ($tech as $key2 => $type) {
                $h = abs(round($type/60, 0, PHP_ROUND_HALF_ODD));
                $m = abs($type%60);
                $times[$key][$key2] = new \DateInterval('PT'.$h.'H'.$m.'M');
            }
        }
        $repo = $em->getRepository('JLMDailyBundle:Maintenance');
        $maintenanceTotal = $repo->getCountTotal(false);
        $date1 = \DateTime::createFromFormat('Y-m-d H:i:s', '2013-01-01 00:00:00');
        $now = new \DateTime;
        $evolutionBase = [];
        for ($i = 1; $i <= 182 && $date1 < $now; $i++) {
            $evolutionBase[$date1->getTimestamp()*1000] = (int)($maintenanceTotal*($i / 182));
            $date1->add(new \DateInterval('P1D'));
        }
        // Nombre de contrats en cours
        $repocon = $em->getRepository('JLMContractBundle:Contract');
        $contracts_numbers = $repocon
            ->createQueryBuilder('a')
            ->select('COUNT(DISTINCT a.number)')
            ->where('?1 BETWEEN a.begin AND a.end')
            ->orWhere('?1 > a.begin AND a.end IS NULL')
            ->setParameter(1, $now)
            ->getQuery()
            ->getSingleScalarResult();
        $contracts_doors = $repocon
            ->createQueryBuilder('a')
            ->select('COUNT(DISTINCT a.door)')
            ->where('?1 BETWEEN a.begin AND a.end')
            ->orWhere('?1 >= a.begin AND a.end IS NULL')
            ->setParameter(1, $now)
            ->getQuery()
            ->getSingleScalarResult();
        $contracts_complete = $repocon
            ->createQueryBuilder('a')
            ->select('COUNT(DISTINCT a.door)')
            ->where('?1 BETWEEN a.begin AND a.end AND a.complete = 1')
            ->orWhere('?1 >= a.begin AND a.end IS NULL AND a.complete = 1')
            ->setParameter(1, $now)
            ->getQuery()
            ->getSingleScalarResult();
        return [
                'numbers'            => $numbers,
                'times'              => $times,
                'maintenanceDoes'    => $repo->getCountDoes(false),
                'maintenanceTotal'   => $maintenanceTotal,
                'evolution'          => $repo->getCountDoesByDay(false),
                'evolutionBase'      => $evolutionBase,
                'contracts_numbers'  => $contracts_numbers,
                'contracts_doors'    => $contracts_doors,
                'contracts_complete' => $contracts_complete,
                'contracts_normal'   => ($contracts_doors - $contracts_complete),
               ];
    }
    
    /**
     * @Route("/info")
     * @Template()
     */
    public function infoAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        phpinfo();
        exit;
    
        return [];
    }
    
    /**
     * @Route("/robot.txt")
     * @Template("@JLMDefault/default/robot.txt.twig")
     */
    public function robotAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return [];
    }
    
    /**
     * @Route("/installation/{code}")
     * @Template()
     */
    public function installationAction($code)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('JLMModelBundle:Door')->getByCode($code);
        if ($entity === null) {
            throw $this->createNotFoundException('Cette installation n\'existe pas');
        }
        
        return ['door' => $entity];
    }
    
    /**
     * @Route("/printtags")
     * @Route("/printtag/{code}")
     */
    public function printtagAction($code = null)
    {
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMModelBundle:Door');
        if ($code === null) {
            $nb = 0;
            $codes = [];
            $lettres = 'AZERTY';
            $request = $this->get('request');
            $max = $request->get('total', 100);
            while ($nb < $max) {
                // On genère un code aléatoire
                $number = rand(0, 9999);
                while (strlen($number) < 4) {
                    $number = '0'.$number;
                }
                $newCode = $lettres[rand(0, 5)].$number;
                // On vérifie s'il n'existe pas en BDD
                $door = $repo->getByCode($newCode);
                if ($door === null && !in_array($newCode, $codes)) {
                    $codes[] = $newCode;
                    $nb++;
                }
            }
        } else {
            $codes = [$code];
        }
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=tags.pdf');
        $out = \JLM\DefaultBundle\Pdf\Tag::get($codes);
        $response->setContent($out);
        
        return $response;
    }
}
