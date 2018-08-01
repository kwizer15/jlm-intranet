<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Mail
{
	/**
	 * @var string $subject
	 * @Assert\Type(type="string")
	 * @Assert\NotNull
	 */
	private $subject;
	
	/**
	 * @var string $from
	 * @Assert\Email
	 * @Assert\NotNull
	 */
	private $from;
	
	/**
	 * @var string $to
	 * @Assert\Email
	 * @Assert\NotNull
	 */
	private $to;
	
	/**
	 * @var string $cc
	 * @Assert\Email
	 */
	private $cc;
	
	/**
	 * @var string $bcc
	 * @Assert\Email
	 */
	private $bcc;
	
	/**
	 * @var string $body
	 * @Assert\Type(type="string")
	 * @Assert\NotNull
	 */
	private $body;
	
	/**
	 * @var string $signature
	 * @Assert\Type(type="string")
	 */
	private $signature;
	
	
	/**
	 * Set Subject
	 * @param string $subject
	 * @return Mail
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
		
		return $this;
	}
	
	/**
	 * Get subject
	 * @return string
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * Set From
	 * @param string $from
	 * @return Mail
	 */
	public function setFrom($from)
	{
		$this->from = $from;
		
		return $this;
	}
	
	/**
	 * Get from
	 * @return string
	 */
	public function getFrom()
	{
		return $this->from;
	}
	
	/**
	 * Set to
	 * @param string $to
	 * @return Mail
	 */
	public function setTo($to)
	{
		$this->to = $to;
		
		return $this;
	}
	
	/**
	 * Get to
	 * @return string
	 */
	public function getTo()
	{
		return $this->to;
	}
	
	/**
	 * Set cc
	 * @param string $cc
	 * @return Mail
	 */
	public function setCc($cc)
	{
		$this->cc = $cc;
		
		return $this;
	}
	
	/**
	 * Get cc
	 * @return string
	 */
	public function getCc()
	{
		return $this->cc;
	}
	
	/**
	 * Set bcc
	 * @param string $bcc
	 * @return Mail
	 */
	public function setBcc($bcc)
	{
		$this->bcc = $bcc;
		
		return $this;
	}
	
	/**
	 * Get bcc
	 * @return string
	 */
	public function getBcc()
	{
		return $this->bcc;
	}
	
	
	/**
	 * Set body
	 * @param string $body
	 * @return Mail
	 */
	public function setBody($body)
	{
		$this->body = $body;
		
		return $this;
	}
	
	/**
	 * Get body
	 * @return string
	 */
	public function getBody()
	{
		return $this->body;
	}
	
	/**
	 * Set signature
	 * @param string $signature
	 * @return Mail
	 */
	public function setSignature($signature)
	{
		$this->signature = $signature;
		
		return $this;
	}
	
	/**
	 * Get signature
	 * @return string
	 */
	public function getSignature()
	{
		return $this->signature;
	}
	
	/**
	 * Get swift mailer message
	 */
	public function getSwift()
	{
		$swift = \Swift_Message::newInstance()
			->setSubject($this->getSubject())
			->setFrom($this->getFrom())
			->setTo($this->getTo())
			->setBcc($this->getBcc())
			->setBody($this->getBody().chr(10).chr(10).'--'.chr(10).$this->getSignature());
		if ($this->getCc() !== null)
		{
			$swift->setCc($this->getCc());
		}
		
		return $swift;
	}
	
}