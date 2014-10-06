<?php

/*
 * This file is part of the JLMBillBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\BillBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface BoostContactInterface
{
    /**
     * @return string
     */
    public function getName();
    
    /**
     * @return string
     */
    public function getPhone();
    
    /**
     * @return string
     */
    public function getEmail();
}