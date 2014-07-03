<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface AttributionInterface
{
    /**
     * Get ask
     *
     * @return \JLM\OfficeBundle\Entity\Ask
     */
    public function getAsk();
    
    /**
     * Get Site
     *
     * @return \JLM\ModelBundel\Entity\Site
     */
    public function getSite();
    
    /**
     * Get transmitters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransmitters();
}