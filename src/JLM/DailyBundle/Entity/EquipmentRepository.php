<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EquipmentRepository
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class EquipmentRepository extends EntityRepository
{	
	public function getCountWithDate(\DateTime $date1, \DateTime $date2)
	{
		$qb = $this->createQueryBuilder('i')
		->select('COUNT(i)')
		->leftJoin('i.shiftTechnicians','t')
		->where('t.begin BETWEEN ?1 AND ?2')
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
			->addOrderBy('t.creation','asc')
			->addOrderBy('i.creation','asc')
			->setParameter(1,$date1)
			->setParameter(2,$date2);
		return $qb->getQuery()->getResult();
	
	}
	
	public function getCountToday()
	{
		$today = new \DateTime;
		$todaystring =  $today->format('Y-m-d');
		// Interventions en cours
		$qb = $this->createQueryBuilder('i')
			->select('COUNT(i)')
			->leftJoin('i.shiftTechnicians','t')
			->where('t.begin = ?1')
			->setParameter(1,$todaystring)
			;
		return $qb->getQuery()->getSingleScalarResult();
	}
	
	public function getToday()
	{
		$today = new \DateTime;
		$todaystring =  $today->format('Y-m-d');
		$qb = $this->createQueryBuilder('i')
			->leftJoin('i.shiftTechnicians','t')
			->where('t.begin = ?1')
			->orderBy('i.creation','asc')
			->setParameter(1,$todaystring)
			;
			
		return $qb->getQuery()->getResult();
	}
	
}
