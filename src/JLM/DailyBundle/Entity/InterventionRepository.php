<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * InterventionRepository
 */
class InterventionRepository extends EntityRepository
{
	public function getPrioritary($limit = null, $offset = null)
	{
		$qb = $this->createQueryBuilder('i')
			->where('i.officeAction IS NULL')
			->orderBy('i.priority','desc')
			->orderBy('i.creation','desc');
		if ($offset)
			$qb->setFirstResult( $offset );
		if ($limit)
   			$qb->setMaxResults( $limit );
		return $qb->getQuery()->getResult();
	}
	
	public function getCountOpened()
	{
		$qb = $this->createQueryBuilder('i')
			->select('COUNT(i)')
			->where('i.officeAction IS NULL');
		return (int) $qb->getQuery()
			->getSingleScalarResult();
	}
}