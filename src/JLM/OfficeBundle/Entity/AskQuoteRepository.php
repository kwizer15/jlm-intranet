<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AskQuoteRepository
 */
class AskQuoteRepository extends EntityRepository
{
	public function getAll()
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
		->orderBy('c.id','asc')
		;
		return $qb->getQuery()->getResult();
	}
	
	public function getTotal()
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
	
	public function getCountUntreated()
	{
		if (!isset($this->untreated))
		{
			$qb = $this->createQueryBuilder('a')
				->select('COUNT(a)')
				->leftJoin('a.quotes','b')
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
	
	public function getUntreated()
	{
		$qb = $this->createQueryBuilder('a')
			->select('a')
			->leftJoin('a.quotes','b')
			->leftJoin('a.intervention','c')
			->where('b is null')
			->andWhere('a.dontTreat is null')
			->orderBy('a.creation','asc')
			;
		return $qb->getQuery()->getResult();
	}
	
	public function getTreated()
	{
		$qb = $this->createQueryBuilder('a')
			->select('a')
			->leftJoin('a.quotes','b')
			->leftJoin('a.intervention','c')
			->where('b is not null')
			->andWhere('a.dontTreat is not null')
			->orderBy('a.creation','asc')
		;
		return $qb->getQuery()->getResult();
	}
}