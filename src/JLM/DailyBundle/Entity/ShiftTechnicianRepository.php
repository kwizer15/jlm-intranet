<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;
use JLM\ModelBundle\Entity\Technician;
use Doctrine\ORM\Query\ResultSetMapping;

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
	
	public function getAll($year = null)
	{
		$today = new \DateTime;
		$year = ($year === null) ? $today->format('Y') : $year;
		$qb = $this->createQueryBuilder('a')
			->select('a,b,c')
			->leftJoin('a.shifting','b')
			->leftJoin('a.technician','c')
			->where('a.begin > ?1')
			->andWhere('a.begin < ?2')
			->setParameter(1, $year.'-01-01 00:00:00')
			->setParameter(2, $year.'-12-31 23:59:59')
		;
		
		return $qb->getQuery()->getResult();
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
	
	public function getStatsByYear($year = null)
	{
		if ($year === null)
		{
			$today = new \DateTime;
			$year = $today->format('Y');
		} 
		$em = $this->getEntityManager();
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('name', 'name');
		$rsm->addScalarResult('actionType', 'type');
		$rsm->addScalarResult('ttime', 'time');
		$rsm->addScalarResult('number', 'number');
		$query = $em->createNativeQuery('
				SELECT b.firstName AS name,
				       d.actionType AS actionType,
				       SUM( TIMESTAMPDIFF(MINUTE,  a.begin, a.end ) ) AS ttime,
				       COUNT(d.actionType) as number
				FROM shift_technician a
				LEFT JOIN persons b ON a.technician_id = b.id
				LEFT JOIN shifting d ON a.shifting_id = d.id
				WHERE YEAR(a.begin) = ?'.
			//	AND a.end IS NOT NULL
				' GROUP BY d.actionType, b.firstName'
			, $rsm);
		$query->setParameter(1,$year);
		return $query->getResult();
	}
}