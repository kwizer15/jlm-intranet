<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CorporationContactRepository extends EntityRepository
{
   
    /**
     *
     * @param int $id
     * @return array|null
     */
    public function getByIdToArray($id)
    {
        $qb = $this->createQueryBuilder('a')
        ->select('a,b,c,d')
        ->leftJoin('a.contact', 'b')
        ->leftJoin('b.phones', 'c')
        ->leftJoin('c.phone', 'd')
        ->where('a.id = :id')
        ->setParameter('id', $id)
        ;
        $res = $qb->getQuery()->getArrayResult();
    
        if (isset($res[0])) {
            return $res[0];
        }
    
        return [];
    }
}
