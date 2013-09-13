<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;
use JLM\ModelBundle\Entity\Technician;

/**
 * StandbyRepository
 */
class StandbyRepository extends EntityRepository
{
	public function getByDate($date)
	{
		 
		$standby = $this->createQueryBuilder('s')
			->where('s.begin <= ?1 AND s.end >= ?1')
			->setParameter(1,$date)
			->setMaxResults(1)
			->getQuery()
			->getResult()
		;
		return empty($standby) ? null : $standby[0]->getTechnician();
	}
	
	public function getCountByDate($date)
	{
		return $this->createQueryBuilder('s')
				->select('COUNT(s)')
				->where('s.begin <= ?1')
				->andWhere('s.end >= ?1')
				->setParameter(1,$date->format('Y-m-d'))
				->getQuery()
				->getSingleScalarResult();
	}
}