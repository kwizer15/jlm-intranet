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
interface BillableContactInterface
{
    /**
     * @return string
     */
    public function getBillingName();
    
    /**
     * @return string
     */
    public function getAccountNumber();
    
    /**
     * @return JLM\ContactBundle\Model\AddressInterface
     */
    public function getBillingAddress();
    
    /**
     * @return BoostContactInterface[]
     */
    public function getBillingBoostContacts();
}