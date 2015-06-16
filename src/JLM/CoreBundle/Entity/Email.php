<?php

namespace JLM\CoreBundle\Entity;

use JLM\CoreBundle\Model\EmailInterface;
/**
 * JLM\CoreBundle\Entity\Mail
 */
class Email implements EmailInterface
{
	/**
	 * @var string $subject
	 */
	private $subject;
	
	/**
	 * @var array $from
	 */
	private $from;
	
	/**
	 * @var array $to
	 */
	private $to;
	
	/**
	 * @var array $cc
	 */
	private $cc;
	
	/**
	 * @var array $bcc
	 */
	private $bcc;
	
	/**
	 * @var string $body
	 */
	private $body;
	
	/**
	 * @var array
	 */
	private $attachements;
	
	public function __construct()
	{
		$this->from = array();
		$this->to = array();
		$this->cc = array();
		$this->bcc = array();
	}
	
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
	public function addFrom($email, $name = null)
	{
		$this->from[] = $email;
		
		return $this;
	}
	
	/**
	 * Set From
	 * @param string $from
	 * @return Mail
	 */
	public function removeFrom($email)
	{
		foreach ($this->from as $key => $from)
		{
			if ($from === $email)
			{
				unset($this->from[$key]);
				
				return true;
			}
		}
	
		return false;
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
	 * Set From
	 * @param string $from
	 * @return Mail
	 */
	public function addTo($email, $name = null)
	{
		$this->to[] = $email;
		
		return $this;
	}
	
	/**
	 * Set From
	 * @param string $from
	 * @return Mail
	 */
	public function removeTo($email)
	{
		foreach ($this->to as $key => $to)
		{
			if ($to === $email)
			{
				unset($this->to[$key]);
				
				return true;
			}
		}
	
		return false;
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
	 * Set From
	 * @param string $from
	 * @return Mail
	 */
	public function addCc($email, $name = null)
	{
		$this->cc[] = $email;
		
		return $this;
	}
	
	/**
	 * Set From
	 * @param string $from
	 * @return Mail
	 */
	public function removeCc($email)
	{
		foreach ($this->cc as $key => $cc)
		{
			if ($cc === $email)
			{
				unset($this->cc[$key]);
				
				return true;
			}
		}
	
		return false;
	}
	
	/**
	 * Get cc
	 * @return array
	 */
	public function getCc()
	{
		return $this->cc;
	}
	
	/**
	 * Set From
	 * @param string $from
	 * @return Mail
	 */
	public function addBcc($email, $name = null)
	{
		$this->bcc[] = $email;
		
		return $this;
	}
	
	/**
	 * Set From
	 * @param string $from
	 * @return Mail
	 */
	public function removeBcc($email)
	{
		foreach ($this->bcc as $key => $bcc)
		{
			if ($bcc === $email)
			{
				unset($this->bcc[$key]);
				
				return true;
			}
		}
	
		return false;
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
	 * Set From
	 * @param string $from
	 * @return Mail
	 */
	public function addAttachement($attach)
	{
		$this->attachements[] = $attach;
	
		return $this;
	}
	
	/**
	 * Set From
	 * @param string $from
	 * @return Mail
	 */
	public function removeAttachement(AttachementInterface $attach)
	{
		foreach ($this->attachements as $key => $attach)
		{
			if (attach === $attach)
			{
				unset($this->attachements[$key]);
	
				return true;
			}
		}
	
		return false;
	}
}