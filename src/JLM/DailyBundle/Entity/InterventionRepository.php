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

use Doctrine\ORM\EntityRepository;

/**
 * InterventionRepository
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class InterventionRepository extends EntityRepository
{
	/**
	 * @deprecated
	 * @param int $limit
	 * @param int $offset
	 */
	public function getPrioritary($limit = null, $offset = null)
	{
		return $this->getOpened($limit, $offset);
		
	}
	
	/**
	 * @return int
	 */
	public function getCountOpened()
	{
		$qb = $this->createQueryBuilder('i')
			->select('COUNT(i)')
			->where('i.mustBeBilled IS NULL');
		return (int) $qb->getQuery()
			->getSingleScalarResult();
	}
	
	/**
	 * 
	 * @param \DateTime $date1
	 * @param \DateTime $date2
	 * @return int
	 */
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
	
	/**
	 * 
	 * @param \DateTime $date1
	 * @param \DateTime $date2
	 * @return ArrayCollection
	 */
	public function getWithDate(\DateTime $date1, \DateTime $date2)
	{
		$qb = $this->createQueryBuilder('i')
			->select('i,s,d,a,b,c,n,e,f,g,h')
			->leftJoin('i.shiftTechnicians','s')
			->leftJoin('s.technician','e')
			->leftJoin('i.door','d')
			->leftJoin('d.interventions','f')
			->leftJoin('d.type','n')
			->leftJoin('d.site','a')
			->leftJoin('a.address','b')
			->leftJoin('b.city','c')
			->leftJoin('i.work','g')
			->leftJoin('i.askQuote','h')
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
		$tomorrowstring = $today->add(new \DateInterval('P1D'))->format('Y-m-d');
		// Interventions en cours
		$qb = $this->createQueryBuilder('i')
			->select('COUNT(i)')
			->leftJoin('i.shiftTechnicians','t')
			->where('t.begin BETWEEN ?1 AND ?2')
			->setParameter(1,$todaystring)
			->setParameter(2,$tomorrowstring)
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
		$tomorrowstring = $today->add(new \DateInterval('P1D'))->format('Y-m-d');
		// Interventions en cours
		$qb = $this->createQueryBuilder('a')
			->select('a,b,k,l,m')
			->leftJoin('a.shiftTechnicians','b')
			->leftJoin('a.askQuote','k')
			->leftJoin('a.work','l')
			->leftJoin('a.bill','m')
			->where('b.begin BETWEEN ?1 AND ?2')
//			->orWhere('b is null')
//			->orWhere('a.close is null')
//			->orWhere('a.report is null')
			->orWhere('a.mustBeBilled is null and b is not null')
			->orWhere('l is null and k is null and a.contactCustomer is null and a.rest is not null and b is not null')
			->orderBy('a.creation','asc')
			->setParameter(1,$todaystring)
			->setParameter(2,$tomorrowstring)
			;
		return $qb->getQuery()->getResult();
	}
	
	public function getToBilled($limit = null, $offset = null)
	{
		$qb = $this->createQueryBuilder('i')
		->select('i,s,d,a,b,c,e,f,g')
		->leftJoin('i.shiftTechnicians','s')
		->leftJoin('i.door','d')
		->leftJoin('d.site','a')
		->leftJoin('a.address','b')
		->leftJoin('b.city','c')
		->leftJoin('i.askQuote','e')
		->leftJoin('i.bill','f')
		->leftJoin('i.work','g')
		->where('i.mustBeBilled = ?1')
		->andWhere('f is null')
		->andWhere('i.externalBill is null')
		->addOrderBy('i.close','asc')
		->setParameter(1,1)
		;
		if ($offset)
			$qb->setFirstResult( $offset );
		if ($limit)
			$qb->setMaxResults( $limit );
		return $qb->getQuery()->getResult();
	}
	
	public function getCountToBilled()
	{
		$qb = $this->createQueryBuilder('i')
		->select('COUNT(i)')
		->where('i.mustBeBilled = ?1')
		->andWhere('i.bill is null')
		->andWhere('i.externalBill is null')
		->addOrderBy('i.close','asc')
		->setParameter(1,1)
		;

		return $qb->getQuery()->getSingleScalarResult();
	}
	
	public function getToContact($limit = null, $offset = null)
	{
		$qb = $this->createQueryBuilder('i')
		->select('i,s,d,a,b,c,e,f,g')
		->leftJoin('i.shiftTechnicians','s')
		->leftJoin('i.door','d')
		->leftJoin('d.site','a')
		->leftJoin('a.address','b')
		->leftJoin('b.city','c')
		->leftJoin('i.askQuote','e')
		->leftJoin('i.bill','f')
		->leftJoin('i.work','g')
		->where('i.contactCustomer = ?1')
		->andWhere('i.contactCustomer is not null')
		->addOrderBy('i.close','asc')
		->setParameter(1,0)
		;
		if ($offset)
			$qb->setFirstResult( $offset );
		if ($limit)
			$qb->setMaxResults( $limit );
		return $qb->getQuery()->getResult();
	}
	
	public function getCountToContact()
	{
		$qb = $this->createQueryBuilder('i')
		->select('COUNT(i)')
		->where('i.contactCustomer = ?1')
		->andWhere('i.contactCustomer is not null')
		->addOrderBy('i.close','asc')
		->setParameter(1,0)
		;
		return $qb->getQuery()->getSingleScalarResult();
	}
	
	public function getOpened($limit = null, $offset = null)
	{
		$qb = $this->createQueryBuilder('a')
		->select('a,b,c,d,e,f,g,h,i')
		->leftJoin('a.shiftTechnicians','b')
		->leftJoin('a.door','c')
		->leftJoin('c.site','d')
		->leftJoin('c.type','e')
		->leftJoin('c.contracts','f')
		->leftJoin('d.trustee','g')
		->leftJoin('d.address','h')
		->leftJoin('h.city','i')
		->where('a.mustBeBilled IS NULL')
		->addOrderBy('a.close','asc')
		->addOrderBy('b.creation','asc')
		->addOrderBy('a.priority','desc')
		->addOrderBy('a.creation','asc');
		if ($offset !== null)
			$qb->setFirstResult( $offset );
		if ($limit !== null)
			$qb->setMaxResults( $limit );
		return $qb->getQuery()->getResult();
	}
	
	protected function leftJoins()
	{
		return $this->createQueryBuilder('a')
		->select($this->getSelect())
		->leftJoin('a.shiftTechnicians','b')
		->leftJoin('a.door','c')
		
		
		
		
		->leftJoin('c.site','d')
		->leftJoin('c.type','e')
		->leftJoin('c.contracts','f')
		->leftJoin('d.trustee','g')
		->leftJoin('d.address','h')
		->leftJoin('h.city','i');
	}
	
	protected function getSelect()
	{
		return 'a,b,c,d,e,f,g,h,i';
	}
}
