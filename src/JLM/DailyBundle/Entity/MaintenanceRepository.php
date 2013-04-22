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
}