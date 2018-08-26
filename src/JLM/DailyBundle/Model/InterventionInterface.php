<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Model;

use JLM\ModelBundle\Entity\Door;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface InterventionInterface
{
    /**
     * @return \DateTime
     */
    public function getLastDate();
    
    /**
     * @return string
     */
    public function getPlace();
    
    /**
     * @return Door
     */
    public function getDoor();
    
    /**
     * @return string
     */
    public function getRest();
    
    /**
     * @return string
     */
    public function getContactName();
    
    /**
     * @return string
     */
    public function getContactPhones();
    
    /**
     * @return string
     */
    public function getContactEmail();
    
    /**
     * @return WorkInterface
     */
    public function getWork();
    
    public function getManagerContacts();
    
    public function getAdministratorContacts();
}
