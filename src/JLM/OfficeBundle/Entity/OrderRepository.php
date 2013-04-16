<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TaskRepository
 */
class OrderRepository extends EntityRepository
{
	public function getTotal()
	{
		return $this->getCount();
	}
	
	public function getCount($state = null)
	{
		if (!isset($this->count))
		{
			$qb = $this->createQueryBuilder('a')
					->select('COUNT(a)')
					->orderBy('a.state','ASC')
					->groupBy('a.state')
			;
			$results = $qb->getQuery()->getResult();
			$this->count[0] = 0;
			$this->total = 0;
			foreach ($results as $result)
			{
				$this->total += $result[1];
				$this->count[] = $result[1];
			}
		}
		if ($state === null)
			return $this->total;
		return $this->count[$state];
	}
	
	public function getByState($state = null,$limit = 10, $offset = 0)
	{
		$qb = $this->createQueryBuilder('t');
		if ($state !== null)
		{
			$qb->where('t.state = ?1')
			->setParameter(1,$state)
			;
		}
		$qb->orderBy('t.creation','asc')
			->setFirstResult($offset)
			->setMaxResults($limit);
		return $qb->getQuery()->getResult();
	}
}