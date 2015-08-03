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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface BoostInterface
{
    /**
	 * @return BusinessInterface
     */
    public function getBusiness(); 

    /**
     * @return string
     */
    public function getCommercialPartNumber();
    
    /**
     * @return CommercialPartInterface
     */
    public function getCommercialPart();
    
    /**
     * @return array
     */
    public function getContacts();   
}