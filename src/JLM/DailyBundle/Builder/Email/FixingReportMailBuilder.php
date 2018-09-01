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
class FixingReportMailBuilder extends FixingMailBuilder
{

    public function buildSubject()
    {
        $this->setSubject('Intervention #'.$this->getFixing()->getId().' Compte-rendu');
    }
    
    public function buildBody()
    {
        $fixing = $this->getFixing();
        $this->setBody('Bonjour,'.chr(10).chr(10)
        .'Suite à notre intervention du '.$fixing->getLastDate()->format('d/m/Y').' sur l\'installation :'.chr(10)
        .chr(10)
        .$fixing->getInstallationCode().chr(10)
        .$fixing->getDoor()->getType().' / '.$fixing->getDoor()->getLocation().chr(10)
        .$fixing->getDoor()->getSite()->getAddress().chr(10)
        .chr(10)
        .trim($fixing->getCustomerReport().chr(10)
        .$fixing->getCustomerActions().chr(10)
        .$fixing->getCustomerState().chr(10)
        .$fixing->getCustomerProcess().chr(10))
        .$this->getSignature());
    }
    
    public function buildAttachements()
    {
    }
}
