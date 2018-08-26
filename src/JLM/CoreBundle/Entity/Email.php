<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Entity;

use JLM\CoreBundle\Model\EmailInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile as AttachementInterface;

//use JLM\CoreBundle\Model\AttachementInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Email implements EmailInterface
{
    /**
     * @var string
     */
    private $subject;
    
    /**
     * @var array
     */
    private $from;
    
    /**
     * @var array
     */
    private $to;
    
    /**
     * @var array
     */
    private $cc;
    
    /**
     * @var array
     */
    private $bcc;
    
    /**
     * @var string
     */
    private $body;
    
    /**
     * @var array
     */
    private $preAttachements;
    
    /**
     * @var array
     */
    private $attachements;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->from = [];
        $this->to = [];
        $this->cc = [];
        $this->bcc = [];
    }
    
    /**
     * Set Subject
     * @param string $subject
     * @return self
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
     * Add from
     * @param string $email
     * @return bool
     */
    public function addFrom($email, $name = null)
    {
        $this->from[] = $email;
        
        return true;
    }
    
    /**
     * Remove from
     * @param string $email
     * @return bool
     */
    public function removeFrom($email)
    {
        foreach ($this->from as $key => $from) {
            if ($from === $email) {
                unset($this->from[$key]);
                
                return true;
            }
        }
    
        return false;
    }
    
    /**
     * Get from emails
     * @return array
     */
    public function getFrom()
    {
        return $this->from;
    }
    
    /**
     * Add To
     * @param string $email
     * @return bool
     */
    public function addTo($email, $name = null)
    {
        $this->to[] = $email;
        
        return true;
    }
    
    /**
     * Remove To
     * @param string $email
     * @return bool
     */
    public function removeTo($email)
    {
        foreach ($this->to as $key => $to) {
            if ($to === $email) {
                unset($this->to[$key]);
                
                return true;
            }
        }
    
        return false;
    }
    
    /**
     * Get to emails
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }
    
    /**
     * Add Cc
     * @param string $email
     * @return bool
     */
    public function addCc($email, $name = null)
    {
        $this->cc[] = $email;
        
        return true;
    }
    
    /**
     * Remove Cc
     * @param string $email
     * @return bool
     */
    public function removeCc($email)
    {
        foreach ($this->cc as $key => $cc) {
            if ($cc === $email) {
                unset($this->cc[$key]);
                
                return true;
            }
        }
    
        return false;
    }
    
    /**
     * Get cc emails
     * @return array
     */
    public function getCc()
    {
        return $this->cc;
    }
    
    /**
     * Add Bcc
     * @param string $email
     * @return bool
     */
    public function addBcc($email, $name = null)
    {
        $this->bcc[] = $email;
        
        return true;
    }
    
    /**
     * Remove Bcc
     * @param string $email
     * @return bool
     */
    public function removeBcc($email)
    {
        foreach ($this->bcc as $key => $bcc) {
            if ($bcc === $email) {
                unset($this->bcc[$key]);
                
                return true;
            }
        }
    
        return false;
    }
    
    /**
     * Get bcc emails
     * @return array
     */
    public function getBcc()
    {
        return $this->bcc;
    }
    
    
    /**
     * Set body
     * @param string $body
     * @return self
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
     * Add attachement
     * @param AttachementInterface $attach
     * @return bool
     */
    public function addAttachement(AttachementInterface $attach)
    {
        $this->attachements[] = $attach;
    
        return true;
    }
    
    /**
     * Remove attachement
     * @param AttachementInterface $attach
     * @return bool
     */
    public function removeAttachement(AttachementInterface $attachr)
    {
        foreach ($this->attachements as $key => $attach) {
            if ($attachr === $attach) {
                unset($this->attachements[$key]);
    
                return true;
            }
        }
    
        return false;
    }
    
    /**
     * Get attahcements
     * @return array
     */
    public function getAttachements()
    {
        return $this->attachements;
    }
    
    /**
     * Add attachement
     * @param AttachementInterface $attach
     * @return bool
     */
    public function addPreAttachement(AttachementInterface $attach)
    {
        $this->preAttachements[] = $attach;
    
        return true;
    }
    
    /**
     * Remove attachement
     * @param AttachementInterface $attach
     * @return bool
     */
    public function removePreAttachement(AttachementInterface $attachr)
    {
        foreach ($this->preAttachements as $key => $attach) {
            if ($attachr === $attach) {
                unset($this->preAttachements[$key]);
    
                return true;
            }
        }
    
        return false;
    }
    
    /**
     * Get attahcements
     * @return array
     */
    public function getPreAttachements()
    {
        return $this->preAttachements;
    }
}
