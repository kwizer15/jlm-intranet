<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Entity;

/**
 * Plannification d'intervention
 * JLM\DailyBundle\Entity\Equipment
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Equipment extends Shifting
{
    /**
     * Get Type
     * @see Shifting
     * @return string
     */
    public function getType()
    {
        return 'equipment';
    }
}
