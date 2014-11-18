<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface CorporationContactInterface extends PersonInterface
{
    /**
     * Get company
     *
     * @return CompanyInterface
     */
    public function getCorporation();
    
    /**
     * Get position
     * Poste dans la société
     *
     * @return string
     */
    public function getPosition();
    
    /**
     * Get manager
     * Responsable éventuel
     *
     * @return null|CorporationContactInterface
     */
    public function getManager();
    
    /**
     * Has manager
     * 
     * @return bool
     */
    public function hasManager();
    
}