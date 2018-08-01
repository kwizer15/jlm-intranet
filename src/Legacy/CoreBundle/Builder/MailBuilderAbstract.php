<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Builder;

use JLM\CoreBundle\Entity\Email;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class MailBuilderAbstract implements MailBuilderInterface
{
	protected $mail;
	
    public function getMail()
    {
    	return $this->mail;
    }
    
    public function create()
    {
    	$this->mail = new Email();
    }
    
    public function setSubject($subject)
    {
    	return $this->mail->setSubject($subject);
    }
    
    public function addFrom($address, $name = null)
    {
    	return $this->mail->addFrom($address, $name);
    }
    
    public function addTo($address, $name = null)
    {
    	return $this->mail->addTo($address, $name);
    }
    
    public function addCc($address, $name = null)
    {
    	return $this->mail->addCc($address, $name);
    }
    
    public function addBcc($address, $name = null)
    {
    	return $this->mail->addBcc($address, $name);
    }
    
    public function setBody($body)
    {
    	return $this->mail->setBody($body);
    }
    
    protected function _getSignature()
    {
    	return chr(10).chr(10)
    	.'--'.chr(10)
    	.'JLM Entreprise'.chr(10)
    	.'17 avenue de Montboulon'.chr(10)
    	.'77165 SAINT-SOUPPLETS'.chr(10)
    	.'Tel : 01 64 33 77 70'.chr(10)
    	.'Fax : 01 64 33 78 45';
    }
    
    public function buildAttachements()
    {
    
    }
    
    public function buildPreAttachements()
    {
    
    }
}