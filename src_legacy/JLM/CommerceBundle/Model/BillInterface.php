<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Model;

use JLM\ModelBundle\Entity\Site;
use JLM\CommerceBundle\Model\CustomerInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface BillInterface
{
    /**
     *
     * @param BusinessInterface $siteObject
     * @return self
     *
     * @deprecated Use setBusiness
     */
    public function setSiteObject(BusinessInterface $siteObject = null);
    
    /**
     * @param BusinessInterface $siteObject
     * @return self
     */
    public function setBusiness(BusinessInterface $business = null);
    
    /**
     *
     * @param string $site
     * @return self
     */
    public function setSite($site);
    
    /**
     *
     * @param CustomerInterface $customer
     * @return self
     */
    public function setCustomer(CustomerInterface $customer = null);
    
    /**
     *
     * @param string $name
     * @return self
    */
    public function setCustomerName($name);
    
    /**
     *
     * @param string $address
     * @return self
    */
    public function setCustomerAddress($address);
    
    /**
     *
     * @param CustomerInterface $customer
     * @return self
     * @deprecated Use setCustomer
     */
    public function setTrustee(CustomerInterface $customer = null);
    
    /**
     *
     * @param string $name
     * @return self
     * @deprecated Use setCustomerName
     */
    public function setTrusteeName($name);
    
    /**
     *
     * @param string $address
     * @return self
     * @deprecated Use setCustomerAddress
     */
    public function setTrusteeAddress($address);
    
    /**
     * @return string
     */
    public function getNumber();
    
    /**
     * @return array
     */
    public function getBoostContacts();
}
