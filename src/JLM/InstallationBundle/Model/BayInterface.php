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
     * The administrator of the bay
     * @return AdministratorInterface
     */
    public function getAdministrator();
    
    /**
     * Get the bay manager
     * @return ManagerInterface
     */
    public function getManager();
    
    /**
     * The location of the bay (help to find)
     * @return string
     */
    public function getLocation();
    
    /**
     * The installation on the bay
     * @return InstallationInteface
     */
    public function getInstallation();
    
    /**
     * Details to access
     * @return string
     */
    public function getObservations();
}
