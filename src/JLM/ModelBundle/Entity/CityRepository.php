<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CityRepository extends EntityRepository
{
	public function searchResult($query, $limit = 8)
	{
		$qb = $this->createQueryBuilder('c')
			   ->where('c.zip LIKE :query')
			   ->orWhere('c.name LIKE :query')
			   ->setParameter('query', '%'.$query.'%')
		;
		$res = $qb->getQuery()->getResult();
		foreach ($res as $r)
		{
			//$obj = new \stdClass;
			//$obj->id = $r->getId();
			//$obj->value = ''.$r;
			//$r2[] = $obj;
			//$r2[''.$r->getId()] = ''.$r;
			$r2[] = $r.'|'.$r->getId();
		}
		return $r2;
	}
}