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
	 * @param Site $siteObject
	 * @return self
	 */
    public function setSiteObject(Site $siteObject = null);
    
    /**
     * 
     * @param unknown $site
	 * @return self
     */
    public function setSite($site);
    
    /**
     * 
     * @param CustomerInterface $customer
	 * @return self
     */
    public function setTrustee(CustomerInterface $customer = null);
    
    /**
     * 
     * @param string $name
	 * @return self
     */
    public function setTrusteeName($name);
    
    /**
     * 
     * @param string $address
	 * @return self
     */
    public function setTrusteeAddress($address);
    
}