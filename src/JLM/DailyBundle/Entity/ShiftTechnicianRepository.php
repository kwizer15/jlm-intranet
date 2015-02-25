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

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;
use JLM\ModelBundle\Entity\Technician;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * ShiftTechnicianRepository
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
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
		return $this->getStatesByPeriod('year', $year);
	}
	
	public function getStatsByMonths($year = null)
	{
		return $this->getStatesByPeriod('month', $year);
	}
	
	public function getStatsByWeeks($year = null)
	{
		return $this->getStatesByPeriod('week', $year);
	}
	
	private function getStatesByPeriod($period = 'year', $year = null)
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
		$query_select = 'SELECT c.name AS name,
				       d.actionType AS actionType,
				       SUM( TIMESTAMPDIFF(MINUTE,  a.begin, a.end ) ) AS ttime,
				       COUNT(d.actionType) as number';
		$query_groupby = ' GROUP BY d.actionType, c.name';
		
		if ($period == 'month')
		{
			$rsm->addScalarResult('month', 'month');
			$query_select .= ', MONTH(a.begin) as month';
			$query_groupby .= ' , MONTH(a.begin)';
		}
		
		if ($period == 'week')
		{
			$rsm->addScalarResult('week', 'week');
			$query_select .= ', WEEK(a.begin) as week';
			$query_groupby .= ' , WEEK(a.begin)';
		}
		
		$query = $em->createNativeQuery($query_select. '
				FROM shift_technician a
				LEFT JOIN technicians b ON a.technician_id = b.id
				LEFT JOIN jlm_contact_contact c ON b.contact_id = c.id
				LEFT JOIN shifting d ON a.shifting_id = d.id
				WHERE YEAR(a.begin) = ?'.
				//	AND a.end IS NOT NULL
				$query_groupby
				, $rsm);
		$query->setParameter(1,$year);
		
		return $query->getResult();
	}
}