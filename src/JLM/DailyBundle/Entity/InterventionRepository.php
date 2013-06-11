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
			->select('i,s,d,a,b,c')
			->leftJoin('i.shiftTechnicians','s')
			->leftJoin('i.door','d')
			->leftJoin('d.site','a')
			->leftJoin('a.address','b')
			->leftJoin('b.city','c')
			->where('i.mustBeBilled IS NULL')
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
			->where('i.mustBeBilled IS NULL');
		return (int) $qb->getQuery()
			->getSingleScalarResult();
	}
	
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
			->select('i,s,d,a,b,c,n,e,f')
			->leftJoin('i.shiftTechnicians','s')
			->leftJoin('s.technician','e')
			->leftJoin('i.door','d')
			->leftJoin('d.interventions','f')
			->leftJoin('d.type','n')
			->leftJoin('d.site','a')
			->leftJoin('a.address','b')
			->leftJoin('b.city','c')
			->where('s.begin BETWEEN ?1 AND ?2')
			->addOrderBy('s.begin','asc')
			->addOrderBy('i.close','asc')
			->addOrderBy('s.creation','asc')
			->addOrderBy('i.priority','desc')
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
//			$intervs = $qb->getQuery()->getResult();
//			foreach ($intervs as $interv)
//				echo $interv->getId().'<br>';
//			return 0;
		return $qb->getQuery()->getSingleScalarResult();
	}
	
	public function getToday()
	{
		$today = new \DateTime;
		$todaystring =  $today->format('Y-m-d');
		// Interventions en cours
		$qb = $this->createQueryBuilder('a')
			->select('a,b,c,d,e,f,g,h,i,j')
			->leftJoin('a.shiftTechnicians','b')
			->leftJoin('a.door','c')
			->leftJoin('c.site','d')
			->leftJoin('c.type','e')
			->leftJoin('c.transmitters','f')
			->leftJoin('c.contracts','g')
			->leftJoin('d.trustee','h')
			->leftJoin('d.address','i')
			->leftJoin('i.city','j')
			->where('b.begin = ?1')
			->orWhere('b is null')
			->orWhere('a.close is null')
			->orWhere('a.report is null')
			->orWhere('a.mustBeBilled is null')
			->orWhere('a.otherAction is null and a.rest is not null')
			->orderBy('a.creation','asc')
			->setParameter(1,$todaystring)
			;
		$intervs = $qb->getQuery()->getResult();
		$inprogress = $fixing = $notclosed = $closed = $work = $maintenance = array();
		foreach ($intervs as $interv)
		{
			$flag = false;
			if ($interv->getClosed() && $interv->getMustBeBilled() && (!$interv->getRest() || $interv->getOtherAction()))
			{
				if (!$flag)
				{
					$closed[] = $interv;
					$flag = true;
				}
			}
			else
			{
				if (sizeof($interv->getShiftTechnicians()) == 0)
				{
					if ($interv instanceof \JLM\DailyBundle\Entity\Fixing)
					{
						if (!$flag)
						{
							$fixing[] = $interv;
							$flag = true;
						}
					}
					elseif ($interv instanceof \JLM\DailyBundle\Entity\Work)
					{
						if (!$flag)
						{
							//$work[] = $interv;
							$flag = true;
						}
					}
					elseif ($interv instanceof \JLM\DailyBundle\Entity\Maintenance)
					{
						if (!$flag)
						{
							//$maintenance[] = $interv;
							$flag = true;
						}
					} 
				}
				else
				{
					foreach ($interv->getShiftTechnicians() as $tech)
					{
						if ($tech->getBegin()->format('Y-m-d') == $todaystring)
						{
							if (!$flag)
							{
								$inprogress[] = $interv;
								$flag = true;
							}	
						}	
					}
				}
			}
			if (!$flag)
			{
				$notclosed[] = $interv;
				$flag = true;
			}
		}
		return array(
				'inprogress'	=> $inprogress,
				'fixing'		=> $fixing,
				'notclosed'		=> $notclosed,
				'closed'		=> $closed,
//				'work'			=> $work,
//				'maintenance'	=> $maintenance,
			);
	}
	
}
