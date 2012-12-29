<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FixingRepository
 */
class FixingRepository extends EntityRepository
{
	public function getPrioritary()
	{
		$qb = $this->createQueryBuilder('f')
			->where('f.officeAction IS NULL')
			->orderBy('f.priority','desc')
			->orderBy('f.creation','desc');
		return $qb->getQuery()->getResult();
	}
	
	public function getCountOpened()
	{
		$qb = $this->createQueryBuilder('f')
			->select('COUNT(f)')
			->where('f.officeAction IS NULL');
		return (int) $qb->getQuery()
			->getSingleScalarResult();
	}
}