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
		$qb = $this->createQueryBuilder('t')
		->select('COUNT(t)');
		
		return (int) $qb->getQuery()
		->getSingleScalarResult();
	}
	
	public function getCount($state = null)
	{
		$qb = $this->createQueryBuilder('t')
		->select('COUNT(t)');
		if ($state !== null)
			$qb->where('t.state = ?1')
				->setParameter(1,$state);

		return (int) $qb->getQuery()
		->getSingleScalarResult();
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