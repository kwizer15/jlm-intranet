<?php

/*
 * This file is part of the JLMFrontBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FrontBundle\Entity;

use JLM\InstallationBundle\Model\InstallationInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Door implements InstallationInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return bool
     */
    public function hasCode()
    {
        return ($this->code !== null);
    }


    // Non implementé
    public function getObservations()
    {
    }

    public function getEndWarranty()
    {
    }

    public function isUnderWarranty()
    {
    }

    public function getWidth()
    {
    }

    public function getHeight()
    {
    }

    public function getActualContract()
    {
    }
}
