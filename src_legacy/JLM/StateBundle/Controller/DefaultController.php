<?php

namespace JLM\StateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default controller.
 */
class DefaultController extends Controller
{
    /**
     * @Route("/technicians/", name="state_technicians")
     * @Route("/technicians/{year}", name="state_technicians_year")
     * @Template()
     */
    public function techniciansAction($year = null)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        // Initialisation des tableaux
        $date = new \DateTime();
        $year = ($year === null) ? $date->format('Y') : $year;
        $base = [
            'fixing' => 0,
            'work' => 0,
            'maintenance' => 0,
            'equipment' => 0,
            'total' => 0,
        ];
        $em = $this->getDoctrine()->getManager();
        $stats = array_merge(
            $em->getRepository('JLMDailyBundle:ShiftTechnician')->getStatsByYear($year),
            $em->getRepository('JLMDailyBundle:ShiftTechnician')->getStatsByMonths($year)
        );

        $numbers = $times = [];
        for ($i = 1; $i <= 12; $i++) {
            $i = str_pad($i, 2, '0', STR_PAD_LEFT);
            $d = new \DateTime($year . '-' . $i . '-01 00:00:00');
            $numbers[$d->format('F')] = $times[$d->format('F')] = ['total' => $base];
        }
        $numbers['Year'] = ['total' => $base];
        $times = $numbers;
        foreach ($stats as $stat) {
            $period = 'Year';
            if (isset($stat['month'])) {
                $d = new \DateTime($year . '-' . $stat['month'] . '-01 00:00:00');
                $period = $d->format('F');
            }
            if (!isset($numbers[$period][$stat['name']])) {
                $numbers[$period][$stat['name']] = $base;
                $times[$period][$stat['name']] = $base;
            }
            $numbers[$period][$stat['name']][$stat['type']] = (int) $stat['number'];
            $numbers[$period][$stat['name']]['total'] += (int) $stat['number'];
            $numbers[$period]['total'][$stat['type']] += (int) $stat['number'];
            $numbers[$period]['total']['total'] += (int) $stat['number'];
            $times[$period][$stat['name']][$stat['type']] = (int) $stat['time'];
            $times[$period][$stat['name']]['total'] += (int) $stat['time'];
            $times[$period]['total'][$stat['type']] += (int) $stat['time'];
            $times[$period]['total']['total'] += (int) $stat['time'];
        }
        foreach ($times as $period => $datas) {
            foreach ($datas as $key => $tech) {
                foreach ($tech as $key2 => $type) {
                    $h = abs(round($type / 60, 0, PHP_ROUND_HALF_ODD));
                    $m = abs($type % 60);
                    $times[$period][$key][$key2] = new \DateInterval('PT' . $h . 'H' . $m . 'M');
                }
            }
        }

        return [
            'year' => $year,
            'numbers' => $numbers,
            'times' => $times,
        ];
    }

    /**
     * @Route("/maintenance", name="state_maintenance")
     * @Template()
     */
    public function maintenanceAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMDailyBundle:Maintenance');
        $maintenanceTotal = $repo->getCountTotal(false);
        $now = new \DateTime();
        $date1 = \DateTime::createFromFormat('Y-m-d H:i:s', $now->format('Y') . '-01-01 00:00:00');

        $evolutionBase = [];
        for ($i = 1; $i <= 365 && $date1 < $now; $i++) {
            $evolutionBase[$date1->getTimestamp() * 1000] = (int) ($maintenanceTotal * ($i / 182));
            $date1->add(new \DateInterval('P1D'));
        }

        return [
            'maintenanceDoes' => $repo->getCountDoes(false),
            'maintenanceTotal' => $maintenanceTotal,
            'evolution' => $repo->getCountDoesByDay(false),
            'evolutionBase' => $evolutionBase,
        ];
    }

    /**
     * @Route("/top", name="state_top")
     * @Template()
     */
    public function topAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMDailyBundle:Fixing');
        $date = new \DateTime();

        return ['results' => $repo->getTop50($date->format('Y') . '-01-01')];
    }

    /**
     * @Route("/contracts", name="state_contracts")
     * @Template()
     */
    public function contractsAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('JLMContractBundle:Contract')->getStatsByMonth();
        $stats = [];
        foreach ($results as $result) {
            if (!isset($stats[$result['year']][$result['month']])) {
                $stats[$result['year']][$result['month']] = 0;
            }
            $stats[$result['year']][$result['month']] = $result['number'];
        }
        return ['stats' => $stats];
    }

    /**
     * @Route("/quote", name="state_quote")
     * @Template()
     */
    public function quoteAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMCommerceBundle:QuoteVariant');
        $add = function ($carry, $item) {
            return $carry + $item->getTotalPrice();
        };

        return [
            'given' => array_reduce($repo->getCountGiven(), $add, 0),
            'total' => array_reduce($repo->getCountSended(), $add, 0),
        ];
    }

    /**
     * @Route("/transmitters", name="state_transmitters")
     * @Template()
     */
    public function transmittersAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $stats = $em->getRepository('JLMTransmitterBundle:Transmitter')->getStatsByMonth();
        $datas = [];
        $byYear = [];
        foreach ($stats as $stat) {
            if (!isset($datas[$stat['year']])) {
                $datas[$stat['year']] = array_fill(1, 12, 0);
                $byYear[$stat['year']] = 0;
            }
            $datas[$stat['year']][$stat['month']] = $stat['number'];
            $byYear[$stat['year']] += $stat['number'];
        }

        return [
            'stats' => $datas,
            'byYear' => $byYear,
        ];
    }

    /**
     * @Route("/sells", name="state_sells")
     * @Template()
     */
    public function sellsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $year = $request->get('year', null);
        $em = $this->getDoctrine()->getManager();
        $stats = $em->getRepository('JLMCommerceBundle:Bill')->getSells($year);
        $total = 0;
        foreach ($stats as $key => $stat) {
            $total += $stat['total'];
            $stats[$key]['pu'] = ($stat['qty'] == 0) ? 0 : ($stat['total'] / $stat['qty']);
        }

        return [
            'stats' => $stats,
            'total' => $total,
        ];
    }

    /**
     * @Route("/daybill", name="state_daybill")
     * @Template()
     */
    public function daybillAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $datas = $this->getDoctrine()->getManager()->getRepository('JLMCommerceBundle:Bill')->getTurnover('month');
        $stats = [];
        foreach ($datas as $data) {
            if (!isset($stats[$data['year']])) {
                $stats[$data['year']] = array_fill(1, 12, 0);
            }
            $stats[$data['year']][$data['month']] = $data['amount'];
        }

        return ['stats' => $stats];
    }

    /**
     * @Route("/lastbill", name="state_lastbill")
     * @Template()
     */
    public function lastbillAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $manager = $this->get('jlm_commerce.bill_manager');
        $entities = $manager->getRepository()->get45Sended();

        return $manager->renderResponse(
            '@JLMState/default/lastbill.html.twig',
            [
                'entities' => $entities,
                'caht' => array_reduce(
                    $entities,
                    function ($carry, $item) {
                        return $carry + $item->getTotalPrice();
                    },
                    0
                ),
                'caati' => array_reduce(
                    $entities,
                    function ($carry, $item) {
                        return $carry + $item->getTotalPriceAti();
                    },
                    0
                ),
                'title' => 'Factures en cours (moins de 45 jours)',
            ]
        );
    }

    /**
     * @Route("/latebill", name="state_latebill")
     * @Template()
     */
    public function latebillAction()
    {
        $manager = $this->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entities = $manager->getRepository()->getSendedMore45();

        return $manager->renderResponse(
            '@JLMState/default/lastbill.html.twig',
            [
                'entities' => $entities,
                'caht' => array_reduce(
                    $entities,
                    function ($carry, $item) {
                        return $carry + $item->getTotalPrice();
                    },
                    0
                ),
                'caati' => array_reduce(
                    $entities,
                    function ($carry, $item) {
                        return $carry + $item->getTotalPriceAti();
                    },
                    0
                ),
                'title' => 'Factures à 45 jours et plus',
            ]
        );
    }

    /**
     * @Route("/doortypes/{year}", name="state_doortypes")
     * @Template()
     */
    public function doortypesAction($year = null)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $date = new \DateTime();
        $maxyear = $date->format('Y');
        $year = ($year === null) ? $maxyear : $year;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMModelBundle:Door');
        $doors = $repo->getCountByType($year);
        $intervs = $repo->getCountIntervsByType($year);
        $complets = $repo->getCountIntervsByTypeAndContract(['C1', 'C2'], $year);
        $normaux = $repo->getCountIntervsByTypeAndContract(['N3', 'N4'], $year);
        $hc = $repo->getCountIntervsByTypeAndContract(['HC', 'Hors contrat'], $year);
        $tot = $totinter = $tottime = 0;
        $total = [
            'C' => 0,
            'N' => 0,
            'HC' => 0,
        ];
        $data = [];
        foreach ($doors as $door) {
            $data[$door['name']] = [
                'nb' => (int) $door['nb'],
                'intervs' => 0,
                'intC' => 0,
                'intN' => 0,
                'intHC' => 0,
                'moyintervs' => 0,
                'time' => new \DateInterval('PT0S'),
                'moytime' => new \DateInterval('PT0S'),
            ];
            $tot += $door['nb'];
            foreach ($intervs as $interv) {
                if ($door['name'] == $interv['name']) {
                    $data[$door['name']]['intervs'] = (int) $interv['nb'];
                    $data[$door['name']]['moyintervs'] = (float) ($interv['nb'] / $door['nb']);
                    $data[$door['name']]['time'] = $this->secondsToInterval($interv['time']);
                    $data[$door['name']]['moytime'] = $this->secondsToInterval($interv['time'] / $door['nb']);

                    $totinter += $interv['nb'];
                    $tottime += $interv['time'];
                }
            }
            foreach (['C' => $complets, 'N' => $normaux, 'HC' => $hc] as $type => $contracts) {
                foreach ($contracts as $interv) {
                    if ($door['name'] == $interv['name']) {
                        $data[$door['name']]['int' . $type] = (int) $interv['nb'];
                        $total[$type] += $interv['nb'];
                    }
                }
            }
        }

        return [
            'datas' => $data,
            'tot' => $tot,
            'totinter' => $totinter,
            'tottime' => $this->secondsToInterval($tottime),
            'moytot' => (float) ($totinter / $tot),
            'moytime' => $this->secondsToInterval($tottime / $tot),
            'year' => $year,
            'maxyear' => $maxyear,
            'totC' => $total['C'],
            'totN' => $total['N'],
            'totHC' => $total['HC'],
        ];
    }

    private function secondsToInterval($seconds)
    {
        $seconds = floor($seconds);
        $hours = floor($seconds / 3600);
        $minutes = floor($seconds / 60) - $hours * 60;

        return new \DateInterval('PT' . $hours . 'H' . $minutes . 'M');
    }

    /**
     * @Route("/quotes/{year}", name="state_quotes")
     * @Template()
     */
    public function quotesAction($year = null)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $date = new \DateTime();
        $maxyear = $date->format('Y');
        $year = ($year === null) ? $maxyear : $year;
        $repo = $this->getDoctrine()->getManager()->getRepository('JLMCommerceBundle:Quote');

        return [
            'sends' => $repo->getSends($year),
            'givens' => $repo->getGivens($year),
            'year' => $year,
            'maxyear' => $maxyear,
        ];
    }
}
