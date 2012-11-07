<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SiteContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SiteContactRepository extends EntityRepository
{
	public function searchResult($query, $limit = 8)
	{
		
		$qb = $this->createQueryBuilder('s')
			   ->leftjoin('s.site','t')
			   ->leftjoin('t.doors','d')
			   ->where('d.id = :query')			   
			   ->setParameter('query', $query)
		;

		$res = $qb->getQuery()->getResult();
		
		$r2 = array();
		foreach ($res as $r)
		{
			$r2[] = array(
				'label'=> $r->getPerson().' ('.$r->getRole().')',
				'name' => $r->getPerson().'',
				'id'=> $r->getId()
			);
		}
		return $r2;
	}

}