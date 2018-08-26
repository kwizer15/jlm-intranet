<?php

/*
 * This file is part of the JLMFrontBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FrontBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DoorRepository extends EntityRepository
{
    /**
     * Get by code
     *
     * @return Door
     */
    public function getByCode($code)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.code = ?1')
            ->setParameter(1, strtoupper($code))
        ;
        
        try {
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $e) {
        }
        
        return null;
    }
}
