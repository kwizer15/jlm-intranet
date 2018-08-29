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
interface InstallationInterface
{

    /**
     * Details to access
     *
     * @return string
     */
    public function getObservations();

    /**
     * Get Warranty
     *
     * @return DateTime|null
     */
    public function getEndWarranty();

    /**
     * Is Under Warranty
     *
     * @return bool
     */
    public function isUnderWarranty();

    /**
     * Get Code installation
     *
     * @return string
     */
    public function getCode();

    /**
     * Has Code installation
     *
     * @return bool
     */
    public function hasCode();

    /**
     * Width
     *
     * @return int
     */
    public function getWidth();

    /**
     * Height
     *
     * @return int
     */
    public function getHeight();

    /**
     * Get actual contract
     *
     * @return ContractInterface
     */
    public function getActualContract();
}
