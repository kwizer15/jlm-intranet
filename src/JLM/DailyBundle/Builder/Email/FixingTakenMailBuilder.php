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
class FixingTakenMailBuilder extends FixingMailBuilder
{

    public function buildSubject()
    {
        $this->setSubject('Intervention #'.$this->getFixing()->getId().' - Demande d\'intervention prise en compte');
    }
    
    public function buildBody()
    {
        $this->setBody(
            'Bonjour,'.chr(10)
            .chr(10)
            .'La demande d\'intervention du '.$this->getFixing()->getAskDate()->format('d/m/Y à H\hi').' pour l\'installation : '.chr(10)
            .$this->getFixing()->getInstallationCode().chr(10)
            .$this->getFixing()->getPlace().chr(10)
            .chr(10)
            .'à bien été prise en compte par nos services.'.chr(10)
            .$this->_getSignature()
        );
    }
}
