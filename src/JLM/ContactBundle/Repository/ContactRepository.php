<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactRepository extends EntityRepository
{
	private function getQueryBuilder()
	{
		return $this->createQueryBuilder('a')
			->select('a')
			//->leftJoin('a.phones','b')
			//->leftJoin('b.phone','c')
		;
	}
	
	/**
	 *
	 * @param string $query
	 * @param int $limit
	 * @return array
	 */
	public function getArray($query, $limit = 10)
	{
		$qb = $this->getQueryBuilder()
			->where('a.name LIKE :query')
			->orderBy('a.name','ASC')
			->setParameter('query', '%'.$query.'%')
		;
		$res = $qb->getQuery()->getArrayResult();
	
		return $res;
	}
	
	public function getAll($limit = 10, $offset = 0)
	{
		$qb = $this->getQueryBuilder()
			->orderBy('a.name')
			->setFirstResult($offset)
			->setMaxResults($limit);
		$res = $qb->getQuery()->getResult();
		
		return $res;
	}
	
	public function getCountAll()
	{
		$qb = $this->createQueryBuilder('a')
			->select('COUNT(a)');
		
		return $qb->getQuery()->getSingleScalarResult();
	}

	/**
	 *
	 * @param int $id
	 * @return array|null
	 */
	public function getByIdToArray($id)
	{
		$qb = $this->getQueryBuilder()
			->where('a.id = :id')
			->setParameter('id', $id)
		;
		$res = $qb->getQuery()->getArrayResult();

		return $res[0];
	}
}