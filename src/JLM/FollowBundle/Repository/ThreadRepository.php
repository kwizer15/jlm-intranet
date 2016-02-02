<?php

/*
 * This file is part of the JLMFollowBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FollowBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use JLM\DailyBundle\Entity\Work;
use JLM\FollowBundle\Entity\Thread;
use JLM\FollowBundle\Model\ThreadInterface;
use JLM\OfficeBundle\Entity\Order;

/**
 * EquipmentRepository
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ThreadRepository extends EntityRepository
{
	/**
	 * 
	 * @param int $page
	 * @param int $resultsByPage
	 * @param string $filter
	 * @return \Doctrine\ORM\Tools\Pagination\Paginator
	 */
	public function getThreads($page, $resultsByPage, $filter = array())
	{
		$types = array('variant', 'intervention');
		$states = array(0,1,2,3,4);
		
		$qb = $this->createQueryBuilder('a')
			->select('a,b')
			->leftJoin('a.starter','b')
			->orderBy('a.startDate','DESC')
			->setFirstResult(($page - 1) * $resultsByPage)
			->setMaxResults($resultsByPage)
		;

		if (key_exists('type', $filter) && in_array($filter['type'], $types))
		{
			$qb->andWhere('b INSTANCE OF :type')
				->setParameter('type', $filter['type']);
		}
		
		if (key_exists('state', $filter) && in_array($filter['state'], $states))
		{
			$qb->andWhere('a.state = :state')
			->setParameter('state', $filter['state']);
		}
		
		$filter['sort'] = isset($filter['sort']) ? $filter['sort'] : '!startDate';
		$sort = str_replace('!', '', $filter['sort']);
		$sort = in_array($sort, array('startDate')) ? $sort : 'startDate';
		$order = (substr($filter['sort'], 0, 1) == '!') ? 'DESC' : 'ASC';
		$qb->orderBy('a.'.$sort, $order);
		
		$query = $qb->getQuery();
		
		return new Paginator($query);
	}
	
	/**
	 * Get Thread from Work linked
	 * @param Work $work
	 * @return Thread
	 */
	public function getByWork(Work $work)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a')
			->leftJoin('a.starter','b')
			->where('b.work = ?1')
			->setParameter(1, $work)
		;
		$query = $qb->getQuery();
		
		return $query->getSingleResult();
	}
	
	/**
	 * Get Thread from Order linked
	 * @param Order $order
	 * @return Thread
	 */
	public function getByOrder(Order $order)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a')
			->letfJoin('a.starter','b')
			->leftJoin('b.work','c')
			->where('c.order = ?1')
			->setParameter(1, $order)
		;
		$query = $qb->getQuery();
	
		return $query->getSingleResult();
	}
}