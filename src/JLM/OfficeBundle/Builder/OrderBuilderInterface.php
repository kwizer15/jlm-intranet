<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Builder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface OrderBuilderInterface
{
    /**
     * @return BillInterface
     */
    public function getOrder();

    public function create();
    
    public function buildCreation();
    
    public function buildTime();
    
    public function buildLines();
    
    public function buildWork();
}