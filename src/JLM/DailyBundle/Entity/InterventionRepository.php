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
			->select('a,b,c,d,e,g,h,i,j,k,l,m,n,z')
			->leftJoin('a.shiftTechnicians','b')
			->leftJoin('a.door','c')
			->leftJoin('c.site','d')
			->leftJoin('c.type','e')
			->leftJoin('c.contracts','g')
			->leftJoin('d.trustee','h')
			->leftJoin('d.address','i')
			->leftJoin('i.city','j')
			->leftJoin('a.askQuote','k')
			->leftJoin('a.work','l')
			->leftJoin('a.bill','m')
			->leftJoin('l.order','n')
			->leftJoin('c.interventions','z')
			->where('b.begin = ?1')
//			->orWhere('b is null')
//			->orWhere('a.close is null')
//			->orWhere('a.report is null')
			->orWhere('a.mustBeBilled is null and b is not null')
			->orWhere('(l is null and k is null and a.contactCustomer is null and a.otherAction is null) and a.rest is not null and b is not null')
			->orderBy('a.creation','asc')
			->setParameter(1,$todaystring)
			;
		return $qb->getQuery()->getResult();
	}
	
	public function getToBilled($limit = null, $offset = null)
	{
		$qb = $this->createQueryBuilder('i')
		->select('i,s,d,a,b,c,e,f,g,h')
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
		->addOrderBy('i.close','asc')
		->setParameter(1,1)
		;

		return $qb->getQuery()->getScalarResult();
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
		->leftJoin('i.shiftTechnicians','s')
		->leftJoin('i.door','d')
		->leftJoin('d.site','a')
		->leftJoin('a.address','b')
		->leftJoin('b.city','c')
		->leftJoin('i.askQuote','e')
		->leftJoin('i.bill','f')
		->where('i.contactCustomer = ?1')
		->andWhere('i.contactCustomer is not null')
		->addOrderBy('i.close','asc')
		->setParameter(1,0)
		;
		return $qb->getQuery()->getScalarResult();
	}
}
