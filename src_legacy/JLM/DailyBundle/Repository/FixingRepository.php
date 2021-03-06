<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Repository;

/**
 * FixingRepository
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FixingRepository extends InterventionRepository
{
    public function getToGive()
    {
        $today = new \DateTime;
        $todaystring =  $today->format('Y-m-d');
        // Interventions en cours
        $qb = $this->createQueryBuilder('a')
            ->select('a,b,k,l,c,e,f,g,h,i,j,m,n')
            ->leftJoin('a.shiftTechnicians', 'b')
            ->leftJoin('a.askQuote', 'k')
            ->leftJoin('a.work', 'l')
            ->leftJoin('a.door', 'c')
            ->leftJoin('c.site', 'e')
            ->leftJoin('e.address', 'f')
            ->leftJoin('f.city', 'g')
            ->leftJoin('e.bills', 'h')
            ->leftJoin('c.stops', 'i')
            ->leftJoin('c.contracts', 'j')
            ->leftJoin('j.trustee', 'm')
            ->leftJoin('c.type', 'n')
            ->where('b.id is null')
            ->orderBy('a.creation', 'asc')
            ;
        return $qb->getQuery()->getResult();
    }

    public function getToday()
    {
        $today = new \DateTime;
        $todaystring =  $today->format('Y-m-d');
        // Interventions en cours
        $qb = $this->createQueryBuilder('a')
        ->select('a,b,k,l,c,e,f,g,h,i,j,m,n')
        ->leftJoin('a.shiftTechnicians', 'b')
        ->leftJoin('a.askQuote', 'k')
        ->leftJoin('a.work', 'l')
        ->leftJoin('a.door', 'c')
        ->leftJoin('c.site', 'e')
        ->leftJoin('e.address', 'f')
        ->leftJoin('f.city', 'g')
        ->leftJoin('e.bills', 'h')
        ->leftJoin('c.stops', 'i')
        ->leftJoin('c.contracts', 'j')
        ->leftJoin('j.trustee', 'm')
        ->leftJoin('c.type', 'n')
        ->where('b.begin = ?1')
        ->orWhere('a.mustBeBilled is null and b.id is not null')
        ->orWhere(
            'l.id is null '
            . 'and k.id is null '
            . 'and a.contactCustomer is null '
            . 'and a.rest is not null '
            . 'and b.id is not null'
        )
        ->orderBy('a.creation', 'asc')
        ->setParameter(1, $todaystring)
        ;
        return $qb->getQuery()->getResult();
    }
}
