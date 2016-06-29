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

use JLM\DefaultBundle\Entity\SearchRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use JLM\CoreBundle\Model\Repository\PaginableInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * BillRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 * 
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillRepository extends SearchRepository implements PaginableInterface
{
	
	public function getTotal()
	{
		return $this->getCount();
	}
	
	public function getLastNumber($year = null)
	{
		if ($year === null)
		{
			$date = new \DateTime;
			$year = $date->format('Y');
		}
		$qb = $this->createQueryBuilder('q')
			->select('MAX(SUBSTRING(q.number,5)) as num')
			->where('SUBSTRING(q.creation, 1, 4) = :year')
			->setMaxResults(1)
			->setParameter('year',$year);
		$result = $qb->getQuery()->getResult();

		return (!$result) ? 0 : $result[0]['num'];
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
		
		return ($state === null) ? $this->total : $this->count[$state];
		
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
		
		$query = $qb->getQuery();
		
		return $query->getResult();
	}
	
	public function getPaginable($page, $resultsByPage, array $filters = array())
	{
		$sorts = array(
			'number' => 'a.number',
//			'date' => 'a.creation',	
		);
		$states = array(
			'in_seizure' => 0,
			'sended' => 1,
			'payed' => 2,
			'canceled' => -1, 
		);
		
		$qb = $this->createQueryBuilder('a')
			->select('a,b,c')
				->leftJoin('a.intervention','b')
				->leftJoin('a.lines','c')
			->setFirstResult(($page - 1) * $resultsByPage)
			->setMaxResults($resultsByPage);
		if (key_exists('state', $filters) && $filters['state'] !== null)
		{
			$state = str_replace('*', '', $filters['state']);
			if (key_exists($state, $states))
			{
				$qb->andWhere('a.state = :state');
			   	$qb->setParameter('state', $states[$state]);
			}
		}
		
		if (key_exists('year', $filters) && $filters['year'] !== null)
		{
			$qb->andWhere('YEAR(a.creation) = :year');
			$qb->setParameter('year', $filters['year']);
		}
		
		if (key_exists('sort', $filters))
		{
			$sort = str_replace('!', '', $filters['sort']);
			if (key_exists($sort, $sorts))
			{
				$order = (substr($filters['sort'], 0, 1) == '!') ? 'DESC' : 'ASC';
				$qb->orderBy($sorts[$sort], $order);
			}
		}
	
		$query = $qb->getQuery();
	
		return new Paginator($query);
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
	
	public function getSendedMore45($limit = 10, $offset = 0)
	{
		$date = new \DateTime();
		$date->sub(new \DateInterval('P45D'));
		$qb = $this->createQueryBuilder('t');
		$qb->where('t.state = ?1')
		->andWhere('t.creation <= ?2')
		->setParameter(1,1)
		->setParameter(2,$date->format('Y-m-d'))
			
		;
		$qb->orderBy('t.number','desc');
	
		return $qb->getQuery()->getResult();
	}
	
	public function get45Sended($limit = 10, $offset = 0)
	{
		$date = new \DateTime();
		$date->sub(new \DateInterval('P45D'));
		$qb = $this->createQueryBuilder('t');
		$qb->where('t.state = ?1')
			->andWhere('t.creation > ?2')
			->setParameter(1,1)
			->setParameter(2,$date->format('Y-m-d'))
			
			;
		$qb->orderBy('t.number','desc');
		
		return $qb->getQuery()->getResult();
	}
	
	public function getCount45Sended()
	{
		$date = new \DateTime();
		$date->sub(new \DateInterval('P45D'));
		$qb = $this->createQueryBuilder('t')
		->select('count(t)')
		->where('t.state = ?1')
			->andWhere('t.creation > ?2')
			->setParameter(1,1)
			->setParameter(2,$date->format('Y-m-d'))
			
			;
		$qb->orderBy('t.number','desc');
		
		return $qb->getQuery()->getResult();
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
			->orWhere('a.state = 1 AND a.firstBoost IS NOT NULL AND a.secondBoost IS NOT NULL AND DATE_ADD(a.secondBoost, 15, \'day\') < CURRENT_DATE()')
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
			->leftJoin('b.contact','f')
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
		return array('a.number','f.name','d.street','e.name','a.trusteeName','a.reference','a.site','a.prelabel');
	}
	
	public function getFees($follower)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a')
			->leftJoin('a.trustee','b')
				->leftJoin('b.contact','f')
			->leftJoin('a.siteObject','c')
				->leftJoin('c.address','d')
					->leftJoin('d.city','e')
			->where('a.feesFollower = ?1')
			->andWhere('a.state >= 0')
			->orderBy('a.number','ASC')
			->setParameter(1, $follower);
		
		return $qb->getQuery()->getResult();
	}
	
	public function getSells($year = null)
	{
		$date = new \DateTime;
		$year = ($year === null) ? $date->format('Y') : $year;

		$em = $this->getEntityManager();
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('reference', 'reference');
		$rsm->addScalarResult('designation', 'designation');
		$rsm->addScalarResult('qty', 'qty');
		$rsm->addScalarResult('total', 'total');
		$query_select = 'SELECT
				a.reference as reference,
				a.designation as designation,
				SUM( a.quantity ) AS qty,
				SUM( a.quantity * a.unit_price) AS total';
		
		$query = $em->createNativeQuery($query_select. '
				FROM bill_lines a
			LEFT JOIN jlm_commerce_bill_join_bill_line b ON a.id = b.billline_id
			LEFT JOIN bill c ON b.bill_id = c.id
			WHERE YEAR( c.creation ) = ?
			AND c.state > 0
			GROUP BY a.designation
			ORDER BY `qty` DESC'
				, $rsm);
		$query->setParameter(1,$year);
		
		return $query->getArrayResult();
	}
	
	public function getDayBill()
	{
		$date = new \DateTime;
		$date->sub(new \DateInterval('P2M'));
		$qb = $this->createQueryBuilder('a')
			->select('a')
			->where('a.creation > ?1')
			//->andWhere('a.state >= 0')
			->orderBy('a.creation','ASC')
			->setParameter(1, $date)
		;
		
		return $qb->getQuery()->getResult();
	}
	
	public function getTurnover($hash, \DateTime $begin = null, \DateTime $end = null, array $options = array())
	{
		$qb = $this->createQueryBuilder('a')
			->select('YEAR(a.creation) as year, MONTH(a.creation) as month, SUM(a.amount) as amount')
			->where('a.fee IS NULL')
			->groupBy('year, month')
			->addOrderBy('year','ASC')
			->addOrderBy('month','ASC');
		
		$query = $qb->getQuery();
		
		return $query->getArrayResult();
	}
}