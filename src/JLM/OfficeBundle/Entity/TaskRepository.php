<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TaskRepository
 */
class TaskRepository extends EntityRepository
{
	public function getTotal()
	{
		$qb = $this->createQueryBuilder('t')
		->select('COUNT(t)');
		
		return (int) $qb->getQuery()
		->getSingleScalarResult();
	}
	
	public function getCountOpened($type = null)
	{
		$qb = $this->createQueryBuilder('t')
		->select('COUNT(t)')
		->where('t.close IS NULL');
		
		if ($type !== null)
		{
			$qb->andWhere('t.type = ?1')
				->setParameter(1,$type)
			;
		}
	
		return (int) $qb->getQuery()
		->getSingleScalarResult();
	}
	
	public function getOpened($type = null,$limit = 10, $offset = 0)
	{
		$qb = $this->createQueryBuilder('t')
		->where('t.close IS NULL');
		if ($type !== null)
		{
			$qb->andWhere('t.type = ?1')
			->setParameter(1,$type)
			;
		}
		$qb->orderBy('t.open','asc')
			->setFirstResult($offset)
			->setMaxResults($limit);
		return $qb->getQuery()->getResult();
	}
}