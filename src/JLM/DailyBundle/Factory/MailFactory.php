<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Factory;

use JLM\DailyBundle\Builder\MailBuilderInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class MailFactory
{
    /**
     * 
     * @param WorkBuilderInterface $bill
     * 
     * @return WorkInterface
     */
    public static function create(MailBuilderInterface $builder)
    {
        $builder->create();
//        $builder->buildCreation();
//        $builder->buildBusiness();
//        $builder->buildReason();
//        $builder->buildContact();
//        $builder->buildPriority();
//        $builder->buildOrder();
//        $builder->buildLink();
        
        return $builder->getReport();
    }
}