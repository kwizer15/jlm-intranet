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
	
	public function getOpened($type = null,$limit = null, $offset = null)
	{
		$qb = $this->createQueryBuilder('a')
		->select('a,b,c,d,e,f,g')
		->leftJoin('a.door','b')
		->leftJoin('b.site','c')
		->leftJoin('c.address','d')
		->leftJoin('d.city','e')
		->leftJoin('a.type','f')
		->leftJoin('b.type','g')
		->where('a.close IS NULL');
		if ($type !== null)
		{
			$qb->andWhere('a.type = ?1')
			->setParameter(1,$type)
			;
		}
		$qb->orderBy('a.open','asc');
		if (null !== $offset)
			$qb->setFirstResult($offset);
		if (null !== $limit)
			$qb->setMaxResults($limit);
		return $qb->getQuery()->getResult();
	}
}