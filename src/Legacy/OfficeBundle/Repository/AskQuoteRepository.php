<?php

namespace JLM\OfficeBundle\Repository;

use JLM\DefaultBundle\Entity\SearchRepository;

/**
 * AskQuoteRepository
 */
class AskQuoteRepository extends SearchRepository
{
	public function getAll($limit = 10, $offset = 0)
	{
		$qb = $this->createQueryBuilder('a')
		->select('a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q')
		->leftJoin('a.quotes','b')
		->leftJoin('a.intervention','c')
		->leftJoin('a.trustee','d')
		->leftJoin('a.site','e')
		->leftJoin('e.address','f')
		->leftJoin('f.city','g')
		->leftJoin('a.door','h')
		->leftJoin('h.site','i')
		->leftJoin('i.address','k')
		->leftJoin('k.city','l')
		->leftJoin('l.country','j')
		->leftJoin('h.type','m')
		->leftJoin('a.method','n')
		->leftJoin('a.person','o')
		->leftJoin('h.contracts','p')
		->leftJoin('p.trustee','q')
		->leftJoin('c.door','r')
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
		$qb = $this->createQueryBuilder('a')
			->select('COUNT(a)')
			->leftJoin('a.quotes','b')
			->where('b is null')
			->andWhere('a.dontTreat is null')
		;
		return 1;
		return $qb->getQuery()->getSingleScalarResult();
	}

	public function getCountTreated()
	{
		$qb = $this->createQueryBuilder('a')
			->select('COUNT(a)')
			->leftJoin('a.quotes','b')
			->where('b is not null')
			->orWhere('a.dontTreat is not null')
		;
		return 1;
		return $qb->getQuery()->getSingleScalarResult();
	}

	public function getUntreated($limit = 10, $offset = 0)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a,b,c,d')
			->leftJoin('a.quotes','b')
			->leftJoin('a.intervention','c')
			->leftJoin('c.door','d')
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
			->leftJoin('a.quotes','b')
			->leftJoin('a.intervention','c')
			->leftJoin('c.door','d')
			->where('b is not null')
			->orWhere('a.dontTreat is not null')
			->orderBy('a.creation','asc')
			->setFirstResult($offset)
			->setMaxResults($limit)
			//->orderBy('a.creation','asc')
		;
		return $qb->getQuery()->getResult();
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getSearchQb()
	{
		return $this->createQueryBuilder('a')
			->select('a')
			->leftJoin('a.quotes','b')
			->leftJoin('a.intervention','c')
			->leftJoin('c.door','d')
			->leftJoin('d.site','e')
			->leftJoin('e.address','f')
			->leftJoin('f.city','g')
		;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getSearchParams()
	{
		return array('d.street','f.street','g.name');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getSearchOrderBy()
	{
		return array('a.creation'=>'asc');
	}

}
