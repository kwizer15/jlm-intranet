<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\DBAL\LockMode;
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
			->select('s, t, f')
			->join('s.technician','t')
			->join('s.shifting','f')
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
	/*
	public function find($id, $lockMode = LockMode::NONE, $lockVersion = null)
	{
		$qb = $this->createQueryBuilder('s')
			->select('s, t, f')
			->join('s.technician','t')
			->join('s.shifting','f')
			->where('s.id = :id')
			->setParameter('id',$id);
		return $qb->getQuery()->getSingleResult();
	} */
}