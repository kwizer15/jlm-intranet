<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\EntityRepository;
use JLM\ModelBundle\Entity\Technician;

/**
 * ShiftTechnicianRepository
 */
class ShiftTechnicianRepository extends EntityRepository
{
	public function getWithoutTime(Technician $technician, $limit = null, $offset = null)
	{
		$qb = $this->createQueryBuilder('s')
			->where('s.technician = ?1')
			->andWhere('s.end is null')
			->orderBy('s.begin','ASC');
		if (null !== $limit)
			$qb->setMaxResults($limit);
		if (null !== $offset)
			$qb->setFirstResult($offset);
		$qb->setParameter(1,$technician);
		return $qb->getQuery()->getResult();
	}
	
	public function getCountWithoutTime(Technician $technician)
	{
		$qb = $this->createQueryBuilder('s')
			->select('COUNT(s)')
			->where('s.technician = ?1')
			->andWhere('s.end is null')
			->setParameter(1,$technician);
		return (int) $qb->getQuery()->getSingleScalarResult();
	}
}