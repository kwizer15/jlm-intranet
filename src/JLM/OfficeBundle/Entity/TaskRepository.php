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
		return $this->getCountOpened();
	}
	
	public function getCountOpened($type = null)
	{
		if (!isset($this->countOpened))
		{
			$qb = $this->createQueryBuilder('a')
					->select('COUNT(a)')
					->where('a.close IS NULL')
					->orderBy('a.type')
					->groupBy('a.type');
			$results = $qb->getQuery()->getResult();
			$this->countOpened[0] = 0;
			$this->total = 0;
			foreach ($results as $result)
			{
				$this->total += $result[1];
				$this->countOpened[] = $result[1];
			}
		}
		if ($type === null)
			return $this->total;
		return $this->countOpened[$type];
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