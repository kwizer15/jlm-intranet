<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JLM\CommerceBundle\Model\BillInterface;
use JLM\CommerceBundle\Model\BillBoostInterface;
use JLM\CommerceBundle\Model\BusinessInterface;

/**
 * BillBoostRepository
 * 
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillBoostRepository extends EntityRepository
{
	/**
	 * 
	 * @param int $numberOfBoosts
	 * @param int $dayAfterLast
	 * @param bool $strict Number of boost is strict
	 * @return array
	 */
	public function getBillsToBoost($numberOfBoosts, $dayAfterLast, $strict = true)
	{
		
		$qb = $this->createQueryBuilder('a')
			->select('a as boost,b as bill')
			->addSelect('MAX(a.date) as lastBoost')
			->addSelect('count(DISTINCT a.id) as nb')
//			->addSelect('b.trusteeName as trusteeName')
//			->addSelect('b.number as number')
//			->addSelect('b.creation as creation')
//			->addSelect('b.site as site')
//			->addSelect('DATE_ADD(b.creation, b.maturity, \'day\') as maturityDate')
//			->addSelect('(SUM(c.unitPrice * c.quantity) / count(DISTINCT a.id)) as totalPrice')
			->leftJoin('a.bill','b')
			->innerJoin('b.lines','c')
			->where('b.state = ?1')
			->groupBy('a.bill')
			->having('nb = ?2 AND DATE_SUB(CURRENT_DATE(), ?3, \'day\') > MAX(a.date)');
		if (!$strict)
		{
			$qb->orHaving('count(DISTINCT a.id) > ?2');
		}
		$qb->setParameter(1, 1)
			->setParameter(2, $numberOfBoosts)
			->setParameter(3, $dayAfterLast)
		;
		
		return $qb->getQuery()->getResult();
	}
	
	/**
	 *
	 * @param BusinessInterface $business
	 * @param int $numberOfBoosts
	 * @param int $dayAfterLast
	 * @param bool $strict Number of boost is strict
	 * @return array
	 */
	public function getBillsToBoostByBusiness(BusinessInterface $business, $numberOfBoosts, $dayAfterLast, $strict = true)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a,b')
				->leftJoin('a.bill','b')
					->innerJoin('b.lines','c')
			->where('b.state = ?1')
			->andWhere('b.siteObject = ?4')
			->groupBy('a.bill')
			->having('count(DISTINCT a.id) = ?2 AND DATE_SUB(CURRENT_DATE(), ?3, \'day\') > MAX(a.date)');
		if (!$strict)
		{
			$qb->orHaving('count(DISTINCT a.id) > ?2');
		}
		$qb->setParameter(1, 1)
			->setParameter(2, $numberOfBoosts)
			->setParameter(3, $dayAfterLast)
			->setParameter(4, $business)
		;
	
		$bills = array();
		$boosts = $qb->getQuery()->getResult();
		foreach($boosts as $boost)
		{
			$bills[] = $boost->getBill();
		}
		
		return $bills;
	}
	
	/**
	 * 
	 * @param BillInterface $bill
	 * @return boolean
	 */
	public function isSend(BillInterface $bill)
	{
		return $this->getCountBoostsByBill($bill) == 1;
	}
	
	/**
	 * Get bill boosts by a bill
	 * @param BillInterface $bill
	 * @param string $inversed
	 * @param string $maxResult
	 * @return array
	 */
	public function getBoostsByBill(BillInterface $bill, $inversed = true, $maxResult = null)
	{
		return $this->_getBoostsByBillQuery($bill, $inversed, $maxResult)->getResult();
	}
	
	/**
	 * Get the last bill boost for bill
	 * @param BillInterface $bill
	 * @return BillBoostInterface
	 */
	public function getLastBoostsByBill(BillInterface $bill)
	{
		return $this->_getBoostsByBillQuery($bill, true, 1)->getSingleResult();
	}
	
	/**
	 * Count the number a bill boost for a bill
	 * @param BillInterface $bill
	 * @return int
	 */
	public function getCountBoostsByBill(BillInterface $bill)
	{
		$qb = $this->createQueryBuilder('a')
			->select('COUNT(a)')
			->where('a.bill = ?1')
			->setParameter(1, $bill)
		;
			
		return $qb->getQuery()->getSingleScalarResult();
	}
	
	/**
	 * Get the query for bill boosts by a bill
	 * @param BillInterface $bill
	 * @param string $inversed
	 * @param string $maxResult
	 * @return \Doctrine\ORM\Query
	 */
	protected function _getBoostsByBillQuery(BillInterface $bill, $inversed = true, $maxResult = null)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a,b')
				->leftJoin('a.method','b')
			->where('a.bill = ?1')
			->orderBy('a.date', $inversed ? 'DESC' : 'ASC')
			->setMaxResults($maxResult)
			->setParameter(1, $bill)
		;
			
		return $qb->getQuery();
	}
}