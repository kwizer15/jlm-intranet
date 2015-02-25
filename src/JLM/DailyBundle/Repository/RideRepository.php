<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JLM\ModelBundle\Entity\Door;

/**
 * RideRepository
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class RideRepository extends EntityRepository
{
	public function getCountRides(Door $door)
	{
		$qb = $this->createQueryBuilder('a')
		->select('COUNT(a)')
		->where('a.departure = ?1')
		->setParameter(1,$door);
		return $qb->getQuery()->getSingleScalarResult();
	}
	
	public function getMaintenanceNeighbor(Door $door,$limit)
	{
		$qb = $this->createQueryBuilder('a')
		->select('a,b,c')
		->leftJoin('a.destination','b')
		->leftJoin('b.interventions','c')
		->where('a.departure = ?1')
		->orderBy('a.duration','ASC')
		->setParameter(1,$door);
		
		$entities = $qb->getQuery()->getResult();
		
		$j = 0;
		$countEntities = sizeof($entities);
		$out = array();
		while (sizeof($out) < $limit && $j < $countEntities)
		{
			if ($entities[$j]->getDestination()->getNextMaintenance())
				$out[] = $entities[$j];
			$j++;
		}
		return $out;
	}
	
	public function hasRide(Door $door, Door $dest)
	{
		if (!isset($this->dests))
			$this->dests = array();
		if (!isset($this->dests[$door->getId()]))
		{
			$this->dests[$door->getId()] = array();
			$qb = $this->createQueryBuilder('a')
			->select('b.id')
			->leftJoin('a.destination','b')
			->where('a.departure = ?1')
			->setParameter(1,$door)
			;
			$dests = $qb->getQuery()->getArrayResult();
			foreach ($dests as $destid)
				$this->dests[$door->getId()][] = $destid['id'];
		}
		return in_array($dest->getId(),$this->dests[$door->getId()]);
	}
}
