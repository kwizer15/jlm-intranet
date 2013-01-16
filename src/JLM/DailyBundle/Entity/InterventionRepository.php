<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * InterventionRepository
 */
class InterventionRepository extends EntityRepository
{
	public function getPrioritary($limit = null, $offset = null)
	{
		$qb = $this->createQueryBuilder('i')
			->leftJoin('i.shiftTechnicians','s')
			->where('i.officeAction IS NULL')
			->addOrderBy('i.close','asc')
			->addOrderBy('s.creation','asc')
			->addOrderBy('i.priority','desc')
			->addOrderBy('i.creation','asc');
		if ($offset)
			$qb->setFirstResult( $offset );
		if ($limit)
   			$qb->setMaxResults( $limit );
		return $qb->getQuery()->getResult();
	}
	
	public function getCountOpened()
	{
		$qb = $this->createQueryBuilder('i')
			->select('COUNT(i)')
			->where('i.officeAction IS NULL');
		return (int) $qb->getQuery()
			->getSingleScalarResult();
	}
	
	public function getCountWithDate(\DateTime $date1, \DateTime $date2)
	{
		$qb = $this->createQueryBuilder('i')
		->select('COUNT(i)')
		->leftJoin('i.shiftTechnicians','t')
		->where('t.begin BETWEEN ?1 AND ?2')
		->orderBy('t.begin','asc')
		->setParameter(1,$date1)
		->setParameter(2,$date2);
		return $qb->getQuery()->getSingleScalarResult();
	
	}
	
	public function getWithDate(\DateTime $date1, \DateTime $date2)
	{
		$qb = $this->createQueryBuilder('i')
			->leftJoin('i.shiftTechnicians','t')
			->where('t.begin BETWEEN ?1 AND ?2')
			->addOrderBy('t.begin','asc')
			->addOrderBy('i.close','asc')
			->addOrderBy('t.creation','asc')
			->addOrderBy('i.priority','desc')
			->addOrderBy('i.creation','asc')
			->setParameter(1,$date1)
			->setParameter(2,$date2);
		return $qb->getQuery()->getResult();
	
	}
}
