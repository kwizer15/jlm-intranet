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

/**
 * StandbyRepository
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class StandbyRepository extends EntityRepository
{
	public function getByDate($date)
	{
		 
		$standby = $this->createQueryBuilder('s')
			->where('s.begin <= ?1 AND s.end >= ?1')
			->setParameter(1,$date)
			->setMaxResults(1)
			->getQuery()
			->getResult()
		;
		return empty($standby) ? null : $standby[0]->getTechnician();
	}
	
	public function getCountByDate($date)
	{
		return $this->createQueryBuilder('s')
				->select('COUNT(s)')
				->where('s.begin <= ?1')
				->andWhere('s.end >= ?1')
				->setParameter(1,$date->format('Y-m-d'))
				->getQuery()
				->getSingleScalarResult();
	}
}