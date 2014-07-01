<?php

namespace JLM\DailyBundle\Entity;

/**
 * MaintenanceRepository
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
			->select('b.begin')
			->leftJoin('a.shiftTechnicians','b')
			->andWhere('a.creation > ?1')
			->andWhere('a.creation <= ?2')
			->andWhere('a.close is not null')
			->orderBy('b.begin','ASC')
			->groupBy('a')
			->setParameter(1, $date1)
			->setParameter(2, $date2);
		$results = $qb->getQuery()->getResult();
		$previousDate = null;
		$datas = array();
		foreach ($results as $result)
		{
			if ($result['begin'] instanceof \DateTime)
			{
				$result['begin']->setTime(0,0,0);
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
			->leftJoin('a.shiftTechnicians','b')
			->leftJoin('a.askQuote','k')
			->leftJoin('a.work','l')
			->leftJoin('a.door','c')
			//->leftJoin('c.interventions','d')
			->leftJoin('c.site','e')
			->leftJoin('e.address','f')
			->leftJoin('f.city','g')
			->leftJoin('e.bills','h')
			->leftJoin('c.stops','i')
			->leftJoin('c.contracts','j')
			->leftJoin('j.trustee','m')
			->leftJoin('c.type','n')
			//->leftJoin('d.shiftTechnicians','o')
			->where('b.begin BETWEEN ?1 AND ?2')
//			->orWhere('b is null')
//			->orWhere('a.close is null')
//			->orWhere('a.report is null')
			->orWhere('b is not null')
			->orWhere('l is null and k is null and a.contactCustomer is null and a.rest is not null and b is not null')
			->orderBy('a.creation','asc')
			->setParameter(1,$todaystring)
			->setParameter(2,$tomorrowstring)
			;
		return $qb->getQuery()->getResult();
	}
}