<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface FixingInterface extends InterventionInterface
{
    public function getId();
    
    public function getInstallationCode();
    
    public function getPlace();
    
    public function getAskDate();
    
    public function getDoor();
    
    public function getDue();
}
