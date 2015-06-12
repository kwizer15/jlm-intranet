<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Builder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class SwiftMailBuilderAbstract implements MailBuilderInterface
{
	private $mail;
	
    public function getMail()
    {
    	return $this->mail;
    }
    
    public function create()
    {
    	$this->mail = \Swift_Message::newInstance();
    }
    
    public function setSubject($subject)
    {
    	$this->mail->setSubject($subject);
    }
    
    public function addFrom($address, $name = null)
    {
    	$this->mail->addFrom($address, $name);
    }
}