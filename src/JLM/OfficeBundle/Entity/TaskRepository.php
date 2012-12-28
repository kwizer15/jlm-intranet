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
	
	public function getCountOpened()
	{
		$qb = $this->createQueryBuilder('t')
		->select('COUNT(t)')
		->where('t.close IS NULL');
	
		return (int) $qb->getQuery()
		->getSingleScalarResult();
	}
	
	public function getOpened()
	{
		$qb = $this->createQueryBuilder('t')
		->where('t.close IS NULL');
	
		return $qb->getQuery()->getResult();
	}
}