<?php

namespace JLM\OfficeBundle\Entity;

use JLM\ModelBundle\Entity\Site;
use JLM\DefaultBundle\Entity\SearchRepository;

/**
 * BillRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BillRepository extends SearchRepository
{
	
	public function getTotal()
	{
		return $this->getCount();
	}
	
	public function getLastNumber()
	{
		$date = new \DateTime;
		$year = $date->format('Y');
		$qb = $this->createQueryBuilder('q')
			->select('SUBSTRING(q.number,5) as num')
			->where('SUBSTRING(q.creation, 1, 4) = :year')
			->orderBy('q.number','DESC')
			->setMaxResults(1)
			->setParameter('year',$year);
		$result = $qb->getQuery()->getResult();
//		var_dump($result); exit;
		if (!$result)
			return 0;
		else
			return $result[0]['num'];
	}
	
	public function getCount($state = null)
	{
		if (!isset($this->count))
		{
			$date = new \DateTime;
			$qb = $this->createQueryBuilder('a')
				->select('a.state, COUNT(a) as c')
				->orderBy('a.state','ASC')
				->groupBy('a.state')
			;
			$results = $qb->getQuery()->getResult();
			$this->count = array(-1=>0,0,0,0,0,0);
			$this->total = 0;
			foreach ($results as $result)
			{
				$this->total += $result['c'];
				$this->count[$result['state']] = $result['c'];
			}
		}
		if ($state === null)
			return $this->total;
		return $this->count[$state];
	}
	
	public function getByState($state = null,$limit = 10, $offset = 0)
	{
		$qb = $this->createQueryBuilder('t');
		if ($state !== null)
		{
			$qb->where('t.state = ?1')
			->setParameter(1,$state)
			;
		}
		$qb->orderBy('t.number','desc')
		->setFirstResult($offset)
		->setMaxResults($limit);
		return $qb->getQuery()->getResult();
	}
	
	public function getAll($limit = 10, $offset = 0)
	{
		return $this->getByState(null,$limit,$offset);
	}
	
	public function getCountAll()
	{
		return $this->getCount();
	}
	
	public function getInSeizure($limit = 10, $offset = 0)
	{
		return $this->getByState(0,$limit,$offset);
	}
	
	public function getCountInSeizure()
	{
		return $this->getCount(0);
	}
	
	public function getSended($limit = 10, $offset = 0)
	{
		return $this->getByState(1,$limit,$offset);
	}
	
	public function getCountSended()
	{
		return $this->getCount(1);
	}
	
	public function getPayed($limit = 10, $offset = 0)
	{
		return $this->getByState(2,$limit,$offset);
	}
	
	public function getCountPayed()
	{
		return $this->getCount(2);
	}
	
	public function getCanceled($limit = 10, $offset = 0)
	{
		return $this->getByState(-1,$limit,$offset);
	}
	
	public function getCountCanceled()
	{
		return $this->getCount(-1);
	}
	
	public function getToBoost()
	{
		return $this->createQueryBuilder('a')
			->select('a')
			->where('a.state = 1 AND a.firstBoost IS NULL AND DATE_ADD(a.creation, a.maturity, \'day\') < CURRENT_DATE()')
			->orWhere('a.state = 1 AND a.firstBoost IS NOT NULL AND a.secondBoost IS NULL AND DATE_ADD(a.firstBoost,a.maturity, \'day\') < CURRENT_DATE()')
			->orWhere('a.state = 1 AND a.firstBoost IS NOT NULL AND a.secondBoost IS NOT NULL AND DATE_ADD(a.secondBoost,a.maturity, \'day\') < CURRENT_DATE()')
			->orderBy('a.creation','ASC')
			->getQuery()
			->getResult();
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getSearchQb()
	{
		return $this->createQueryBuilder('a')
		->select('a')
		->leftJoin('a.trustee','b')
		->leftJoin('a.siteObject','c')
		->leftJoin('c.address','d')
		->leftJoin('d.city','e')
		;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getSearchParams()
	{
		return array('a.number','b.name','d.street','e.name');
	}
}