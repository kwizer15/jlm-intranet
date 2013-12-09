<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Entity\ContactData;
use JLM\ContactBundle\Model\EmailInterface;

/**
 * ContactEmail
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ContactEmail extends ContactData implements ContactEmailInterface
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
     * @param EmailInterface $email
     * @return ContactEmail
     */
    public function setEmail(EmailInterface $email = null)
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