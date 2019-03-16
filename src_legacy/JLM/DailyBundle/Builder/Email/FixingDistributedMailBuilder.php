<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Builder\Email;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FixingDistributedMailBuilder extends FixingMailBuilder
{

    public function buildSubject()
    {
        $this->setSubject('Intervention distribuée');
    }
    
    public function buildBody()
    {
        $this->setBody('Bonjour,'.chr(10).chr(10)
        .'Le technicien est en route'
        .$this->getSignature());
    }
    
    public function buildAttachements()
    {
    }
}
