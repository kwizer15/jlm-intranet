<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Entity\Email;
use JLM\ContactBundle\Entity\ContactData;

/**
 * ContactEmail
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ContactEmail extends ContactData
{
    /**
     * @var Email
     * 
     * @ORM\ManyToOne(targetEntity="Email")
     */
    private $email;
    
    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
    	return (string)$this->getEmail();
    }

    /**
     * Set email
     *
     * @param \JLM\ContactBundle\Entity\Email $email
     * @return ContactEmail
     */
    public function setEmail(\JLM\ContactBundle\Entity\Email $email = null)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return \JLM\ContactBundle\Entity\Email 
     */
    public function getEmail()
    {
        return $this->email;
    }
}