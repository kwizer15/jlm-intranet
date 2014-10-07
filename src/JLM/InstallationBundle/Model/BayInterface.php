<?php

/*
 * This file is part of the JLMInstallationBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\InstallationBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface BayInterface
{
    /**
     * The address of th bay
     * @return AddressInterface
     */    
    public function getAddress();
    
    /**
     * The property of the bay
     * @return PropertyInterface
     */
    public function getProperty();
    
    /**
     * Get the property manager
     * @return ManagerInterface
     */
    public function getPropertyManager();
    
    /**
     * The location of the bay (help to find)
     * @return string
     */
    public function getLocation();
    
    /**
     * The installation in the bay
     * @return InstallationInteface
     */
    public function getInstallation();
    
    /**
     * Details to access
     * @return string
     */
    public function getObservations();
    
    /**
     * Width
     * @return int
     */
    public function getWidth();
    
    /**
     * Height
     * @return int
     */
    public function getHeight();
}