<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Repository;

use JLM\ModelBundle\Entity\Door;

/**
 * MaintenanceRepository
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class MaintenanceRepository extends InterventionRepository
{
    public function getCountDoes($secondSemestre, $year = null)
    {
        $today = new \DateTime;
        $year = ($year === null) ? $today->format('Y') : $year;
        $date1 = ($secondSemestre) ? $year.'-07-01 00:00:00' : $year.'-01-01 00:00:00';
        $date2 = ($secondSemestre) ? $year.'-12-31 23:59:59' : $year.'-06-30 23:59:59';

        $qb = $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->andWhere('a.creation > ?1')
            ->andWhere('a.creation <= ?2')
            ->andWhere('a.close is not null')
            ->setParameter(1, $date1)
            ->setParameter(2, $date2)
        ;
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getCountTotal($secondSemestre, $year = null)
    {
        $today = new \DateTime;
        $year = ($year === null) ? $today->format('Y') : $year;
        $date1 = ($secondSemestre) ? $year.'-07-01 00:00:00' : $year.'-01-01 00:00:00';
        $date2 = ($secondSemestre) ? $year.'-12-31 23:59:59' : $year.'-06-30 23:59:59';

        $qb = $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->andWhere('a.creation > ?1')
            ->andWhere('a.creation <= ?2')
            ->setParameter(1, $date1)
            ->setParameter(2, $date2)
        ;
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getCountDoesByDay($secondSemestre, $year = null)
    {
        $today = new \DateTime;
        $year = ($year === null) ? $today->format('Y') : $year;
        $date1 = ($secondSemestre) ? $year.'-07-01 00:00:00' : $year.'-01-01 00:00:00';
        $date2 = ($secondSemestre) ? $year.'-12-31 23:59:59' : $year.'-06-30 23:59:59';
        $qb = $this->createQueryBuilder('a')
            ->select('DATE(b.begin) as dt, COUNT(a) as number')
            ->leftJoin('a.shiftTechnicians', 'b')
            ->andWhere('a.creation > ?1')
            ->andWhere('a.creation <= ?2')
            ->andWhere('a.close is not null')
            ->orderBy('dt', 'ASC')
            ->groupBy('dt')
            ->setParameter(1, $date1)
            ->setParameter(2, $date2)
            ;
        $results = $qb->getQuery()->getResult();
        $datas = [];

        foreach ($results as $result) {
            // @TODO Bug si pas de tech sur un entretien cloturé
            $datas[\DateTime::createFromFormat('Y-m-d', $result['dt'])->getTimestamp()] = $result['number'];
        }

        //print_r($datas); exit;
        return $datas;
    }

    public function getCountDoesByDayOld($secondSemestre, $year = null)
    {
        $today = new \DateTime;
        $year = ($year === null) ? $today->format('Y') : $year;
        $date1 = ($secondSemestre) ? $year.'-07-01 00:00:00' : $year.'-01-01 00:00:00';
        $date2 = ($secondSemestre) ? $year.'-12-31 23:59:59' : $year.'-06-30 23:59:59';
        $qb = $this->createQueryBuilder('a')
        ->select('b.begin')
        ->leftJoin('a.shiftTechnicians', 'b')
        ->andWhere('a.creation > ?1')
        ->andWhere('a.creation <= ?2')
        ->andWhere('a.close is not null')
        ->orderBy('b.begin', 'ASC')
        ->groupBy('a')
        ->setParameter(1, $date1)
        ->setParameter(2, $date2);
        $results = $qb->getQuery()->getResult();
        $previousDate = null;
        $datas = [];
        foreach ($results as $result) {
            if ($result['begin'] instanceof \DateTime) {
                $result['begin']->setTime(0, 0, 0);
                $ts = $result['begin']->getTimestamp()*1000;
                $datas[$ts] = ($previousDate === null) ? 1 : $datas[$previousDate] + 1;
                $previousDate = $ts;
            }
        }
        return $datas;
    }

    public function getToday()
    {
        $today = new \DateTime;
        $todaystring =  $today->format('Y-m-d');
        $tomorrowstring = $today->add(new \DateInterval('P1D'))->format('Y-m-d');
        // Interventions en cours
        $qb = $this->createQueryBuilder('a')
            ->select('a,b,k,l,c,e,f,g,h,i,j,m,n')
            ->leftJoin('a.shiftTechnicians', 'b')
            ->leftJoin('a.askQuote', 'k')
            ->leftJoin('a.work', 'l')
            ->leftJoin('a.door', 'c')
            //->leftJoin('c.interventions','d')
            ->leftJoin('c.site', 'e')
            ->leftJoin('e.address', 'f')
            ->leftJoin('f.city', 'g')
            ->leftJoin('e.bills', 'h')
            ->leftJoin('c.stops', 'i')
            ->leftJoin('c.contracts', 'j')
            ->leftJoin('j.trustee', 'm')
            ->leftJoin('c.type', 'n')
            //->leftJoin('d.shiftTechnicians','o')
            ->where('b.begin BETWEEN ?1 AND ?2')
//          ->orWhere('b is null')
//          ->orWhere('a.close is null')
//          ->orWhere('a.report is null')
            ->orWhere('a.mustBeBilled is null and b.id is not null')
            ->orWhere('l.id is null and k.id is null and a.contactCustomer is null and a.rest is not null and b.id is not null')
            ->orderBy('a.creation', 'asc')
            ->setParameter(1, $todaystring)
            ->setParameter(2, $tomorrowstring)
            ;
        return $qb->getQuery()->getResult();
    }
}
