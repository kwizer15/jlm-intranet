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

use JLM\ContactBundle\Model\PersonInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface UnionCouncilMemberInterface extends PersonInterface
{
    /**
     * Get the union council
     * @return UnionCouncilInterface
     */
    public function getUnionCouncil();
}