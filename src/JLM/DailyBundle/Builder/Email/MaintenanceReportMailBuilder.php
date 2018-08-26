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
class MaintenanceReportMailBuilder extends MaintenanceMailBuilder
{

    public function buildSubject()
    {
        $this->setSubject('Visite d\'entretien de l\'installation '.$this->getMaintenance()->getInstallationCode());
    }
    
    public function buildBody()
    {
        $maintenance = $this->getMaintenance();
        $this->setBody('Bonjour,'.chr(10).chr(10)
        .'La visite d\'entretien de l\'installation : '.chr(10)
        .$maintenance->getInstallationCode().chr(10)
        .$maintenance->getPlace().chr(10)
        .'a été effectuée le '.$maintenance->getLastDate()->format('d/m/Y')
        .$this->_getSignature());
    }
}
