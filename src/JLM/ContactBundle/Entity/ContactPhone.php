<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Entity\ContactData;
use JLM\ContactBundle\Model\PhoneInterface;

/**
 * ContactPhone
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ContactPhone extends ContactData implements ContactPhoneInterface
{
    /**
     * @var Phone
     * 
     * @ORM\ManyToOne(targetEntity="Phone")
     */
    private $phone;
    
    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
    	return (string)$this->getPhone();
    }

    /**
     * Set phone
     *
     * @param \JLM\ContactBundle\Entity\Phone $phone
     * @return ContactPhone
     */
    public function setPhone(PhoneInterface $phone = null)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return \JLM\ContactBundle\Entity\Phone 
     */
    public function getPhone()
    {
        return $this->phone;
    }
}