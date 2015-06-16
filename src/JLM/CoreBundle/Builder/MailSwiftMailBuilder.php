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

use JLM\CoreBundle\Model\EmailInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class MailSwiftMailBuilder extends SwiftMailBuilderAbstract
{
	private $email;
	
	public function __construct(EmailInterface $email)
	{
		$this->email = $email;
	}
	
    public function buildSubject()
    {
    	$this->setSubject($this->email->getSubject());
    }
    
    public function buildFrom()
    {
    	$flag = false;
    	foreach ($this->email->getFrom() as $email)
    	{
    		if (!$flag)
    		{
    			$this->getMail()->setReadReceiptTo($email);
    		}
    		$this->addFrom($email);
    	}
    }
    
    public function buildTo()
    {
    	foreach ($this->email->getTo() as $email)
    	{
    		$this->addTo($email);
    	}
    }
    
    public function buildCc()
    {
    	foreach ($this->email->getCc() as $email)
    	{
    		$this->addCc($email);
    	}
    }
    
    public function buildBcc()
    {
    	foreach ($this->email->getBcc() as $email)
    	{
    		$this->addBcc($email);
    	}
    }
    
    public function buildBody()
    {
    	$this->setBody($this->email->getBody(), 'text/plain', 'utf-8');
    }
    
    public function buildAttachements()
    {
    	
    }
}