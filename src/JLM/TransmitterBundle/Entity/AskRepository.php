<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AskContractRepository
 */
class AskRepository extends EntityRepository
{
	public function getAll($limit = 10, $offset = 0)
	{
		$qb = $this->createQueryBuilder('a')
		->select('a,b,d,e,f,g,n,o')
		->leftJoin('a.trustee','d')
		->leftJoin('a.attributions','b')
		->leftJoin('a.site','e')
		->leftJoin('e.address','f')
		->leftJoin('f.city','g')
		->leftJoin('a.method','n')
		->leftJoin('a.person','o')
		->orderBy('a.creation','asc')
		->setFirstResult($offset)
		->setMaxResults($limit);
		;
		return $qb->getQuery()->getResult();
	}
	
	public function getCountAll()
	{
		if (!isset($this->total))
		{
			$qb = $this->createQueryBuilder('a')
					->select('COUNT(a)')
			;
			$this->total = $qb->getQuery()->getSingleScalarResult();
		}
		return $this->total;
	}
	
	/**
	 * @deprecated
	 */
	public function getTotal()
	{
		return $this->getCountAll();
	}
	
	public function getCountUntreated()
	{
		if (!isset($this->untreated))
		{
			$qb = $this->createQueryBuilder('a')
				->select('COUNT(a)')
				->leftJoin('a.attributions','b')
				->where('b is null')
				->andWhere('a.dontTreat is null')
			;
			$this->untreated = $qb->getQuery()->getSingleScalarResult();
		}
		return $this->untreated;
	}
	
	public function getCountTreated()
	{
		return $this->getTotal() - $this->getCountUntreated();
	}
	
	public function getUntreated($limit = 10, $offset = 0)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a')
			->leftJoin('a.attributions','b')
			->where('b is null')
			->andWhere('a.dontTreat is null')
			->orderBy('a.creation','asc')
			->setFirstResult($offset)
			->setMaxResults($limit)
			;
		return $qb->getQuery()->getResult();
	}
	
	public function getTreated($limit = 10, $offset = 0)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a')
			->leftJoin('a.attributions','b')
			->where('b is not null')
			->orWhere('a.dontTreat is not null')
			->orderBy('a.creation','asc')
			->setFirstResult($offset)
			->setMaxResults($limit)
			//->orderBy('a.creation','asc')
		;
		return $qb->getQuery()->getResult();
	}
}