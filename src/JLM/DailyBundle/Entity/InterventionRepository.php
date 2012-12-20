<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * InterventionRepository
 */
class InterventionRepository extends EntityRepository
{
	public function getPrioritary()
	{
		$qb = $this->createQueryBuilder('i')
			->where('i.closed = false')
			->orderBy('i.priority','desc')
			->orderBy('i.creation','desc');
		return $qb->getQuery()->getResult();
	}
	
	public function getCountOpened()
	{
		$qb = $this->createQueryBuilder('i')
			->select('COUNT(f)')
			->where('i.closed = false');
		return (int) $qb->getQuery()
			->getSingleScalarResult();
	}
}