<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JLM\ContactBundle\Entity\ContactAddress;
use JLM\ContactBundle\Entity\ContactPhone;
use JLM\ContactBundle\Entity\ContactEmail;

/**
 * Contact
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * ORM\DiscriminatorMap({
 * 		"person" = "Person",
 *      "technician" = "Technician",
 *      "company" = "Company"
 */
abstract class Contact
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="ContactEmail", mappedBy="contact")
     */
    private $emails;

    /**
     * @var string
     * 
     * @ORM\OneToMany(targetEntity="ContactAddress", mappedBy="contact")
     */
    private $addresses;
    
    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="ContactPhone", mappedBy="contact")
     */
    private $phones;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add emails
     *
     * @param ContactEmail $emails
     * @return Contact
     */
    public function addEmail(ContactEmail $email)
    {
    	$email->setContact($this);
        $this->emails[] = $email;
    
        return $this;
    }

    /**
     * Remove emails
     *
     * @param ContactEmail $email
     * @return self
     */
    public function removeEmail(ContactEmail $email)
    {
    	$email->setContact();
        $this->emails->removeElement($email);
        
        return $this;
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add phones
     *
     * @param ContactPhone $phone
     * @return Contact
     */
    public function addPhone(ContactPhone $phone)
    {
    	$phone->setContact($this);
        $this->phones[] = $phone;
    
        return $this;
    }

    /**
     * Remove phones
     *
     * @param ContactPhone $phone
     * @return self
     */
    public function removePhone(ContactPhone $phone)
    {
    	$phone->setContact();
        $this->phones->removeElement($phone);
        
        return $this;
    }

    /**
     * Get phones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Add addresses
     *
     * @param ContactAddress $address
     * @return Contact
     */
    public function addAddress(ContactAddress $address)
    {
    	$address->setContact($this);
        $this->addresses[] = $address;
    
        return $this;
    }

    /**
     * Remove addresses
     *
     * @param ContactAddress $address
     * @return self
     */
    public function removeAddress(ContactAddress $address)
    {
    	$address->setContact();
        $this->addresses->removeElement($address);
        
        return $this;
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
}