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
}