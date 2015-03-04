<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Builder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface WorkBuilderInterface
{
    /**
     * @return BillInterface
     */
    public function getWork();

    public function create();
    
    public function buildCreation();
    
    public function buildBusiness();
    
    public function buildReason();
    
    public function buildContact();

    public function buildPriority();
    
    public function buildOrder();
    
    public function buildLink();
}