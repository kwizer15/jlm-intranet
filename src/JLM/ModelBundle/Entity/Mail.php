<?php

namespace JLM\ModelBundle\Entity;

/**
 * JLM\OfficeBundle\Entity\Mail
 */
class Mail
{
	/**
	 * @var string $subject
	 */
	private $subject;
	
	/**
	 * @var string $from
	 */
	private $from;
	
	/**
	 * @var string $to
	 */
	private $to;
	
	/**
	 * @var string $cc
	 */
	private $cc;
	
	/**
	 * @var string $body
	 */
	private $body;
	
	/**
	 * @var string $signature
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
		return \Swift_Message::newInstance()
			->setSubject($this->getSubject())
			->setFrom($this->getFrom())
			->setTo($this->getTo())
			->setBcc($this->getCc())
			->setBody($this->getBody().chr(10).chr(10).'--'.chr(10).$this->getSignature());
	}
	
}