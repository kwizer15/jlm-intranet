<?php

/*
 * This file is part of the JLMCondominiumBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CondominiumBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface CondominiumInterface
{

    /**
     * Get the name
     * ex : Résidence de la Dhuys
     * @return string
     */
    public function getName();
    
    /**
     * Get the administrator
     * ex : SDC Résidence de la Dhuys
     * @return AdministratorInterface
     */
    public function getAdministrator();
}
