<?php

/*
 * This file is part of the JLMFollowBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FollowBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use JLM\DailyBundle\Entity\Work;
use JLM\FollowBundle\Entity\Thread;
use JLM\FollowBundle\Model\ThreadInterface;
use JLM\OfficeBundle\Entity\Order;
use JLM\CoreBundle\Model\Repository\PaginableInterface;
use JLM\DailyBundle\Entity\ShiftTechnician;

/**
 * EquipmentRepository
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ThreadRepository extends EntityRepository implements PaginableInterface
{
    /**
     *
     * @param int $page
     * @param int $resultsByPage
     * @param string $filter
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getPaginable($page, $resultsByPage, array $filters = [])
    {
        $types = ['variant', 'intervention'];
        $states = [0,1,2,3,4];
        $sorts = ['date' => 'a.startDate'];
        
        $qb = $this->createQueryBuilder('a')
            ->select('a,b')
            ->leftJoin('a.starter', 'b')
            ->setFirstResult(($page - 1) * $resultsByPage)
            ->setMaxResults($resultsByPage)
        ;

        if (key_exists('type', $filters) && in_array($filters['type'], $types) && $filters['type'] !== null) {
            $qb->andWhere('b INSTANCE OF :type')
               ->setParameter('type', $filters['type']);
        }
        
        if (key_exists('state', $filters) && in_array($filters['state'], $states) && $filters['state'] !== null) {
            $qb->andWhere('a.state = :state')
               ->setParameter('state', $filters['state']);
        }
        
        if (key_exists('sort', $filters)) {
            $sort = str_replace('!', '', $filters['sort']);
            if (key_exists($sort, $sorts)) {
                $order = (substr($filters['sort'], 0, 1) == '!') ? 'DESC' : 'ASC';
                $qb->orderBy($sorts[$sort], $order);
            }
        }
        
        $query = $qb->getQuery();
        
        return new Paginator($query);
    }
    
    /**
     * Get Thread from Work linked
     * @param Work $work
     * @return Thread
     */
    public function getByWork(Work $work)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->leftJoin('a.starter', 'b')
            ->where('b.work = ?1')
            ->setParameter(1, $work)
        ;
        $query = $qb->getQuery();
        
        return $query->getSingleResult();
    }
    
    /**
     * Get Thread from Order linked
     * @param Order $order
     * @return Thread
     */
    public function getByOrder(Order $order)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->leftJoin('a.starter', 'b')
            ->leftJoin('b.work', 'c')
            ->where('c.order = ?1')
            ->setParameter(1, $order)
        ;
        $query = $qb->getQuery();
    
        return $query->getSingleResult();
    }
    
    /**
     * Get Thread from ShiftTechnician linked
     * @param ShiftTechnician $st
     * @return Thread
     */
    public function getByShiftTechnician(ShiftTechnician $st)
    {
        $qb = $this->createQueryBuilder('a')
        ->select('a')
        ->leftJoin('a.starter', 'b')
        ->leftJoin('b.work', 'c')
        ->leftJoin('c.shiftTechnicians', 'd')
        ->where('d.id = ?1')
        ->setParameter(1, $st->getId())
        ;
        $query = $qb->getQuery();
    
        return $query->getSingleResult();
    }
}
