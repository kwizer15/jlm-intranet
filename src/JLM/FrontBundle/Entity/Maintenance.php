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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Maintenance
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Door
     */
    private $door;

    /**
     * @var int
     */
    private $year;

    /**
     * @var int
     */
    private $ranking;

    /**
     * @var DateTime|null
     */
    private $date = null;
}
