<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserGroupRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserGroupRepository extends EntityRepository
{
	private $lastSiteId;
	private $lastQb;
	
	public function getFromSite($id)
	{
		if ($this->lastSiteId != $id)
		{
			$this->lastSiteId = $id;
			$this->lastQb = $this->createQueryBuilder('a')
				->leftJoin('a.site','b')
				->where('b.id = ?1')
				->setParameter(1,$id);
		}
		
		return $this->lastQb;
	}
}
