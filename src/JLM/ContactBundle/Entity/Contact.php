<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\ContactRepository")
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
     * @ORM\OneToMany(targetEntity="Email", mappedBy="contact")
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
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="contact")
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
        $this->address = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add emails
     *
     * @param \JLM\ContactBundle\Entity\Email $emails
     * @return Contact
     */
    public function addEmail(\JLM\ContactBundle\Entity\Email $email)
    {
    	$email->setContact($this);
        $this->emails[] = $email;
    
        return $this;
    }

    /**
     * Remove emails
     *
     * @param \JLM\ContactBundle\Entity\Email $email
     */
    public function removeEmail(\JLM\ContactBundle\Entity\Email $email)
    {
    	$email->setContact();
        $this->emails->removeElement($email);
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
     * @param \JLM\ContactBundle\Entity\Phone $phone
     * @return Contact
     */
    public function addPhone(\JLM\ContactBundle\Entity\Phone $phone)
    {
    	$phone->setContact($this);
        $this->phones[] = $phone;
    
        return $this;
    }

    /**
     * Remove phones
     *
     * @param \JLM\ContactBundle\Entity\Phone $phone
     */
    public function removePhone(\JLM\ContactBundle\Entity\Phone $phone)
    {
    	$phone->setContact();
        $this->phones->removeElement($phone);
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
     * @param \JLM\ContactBundle\Entity\ContactAddress $address
     * @return Contact
     */
    public function addAddress(\JLM\ContactBundle\Entity\ContactAddress $address)
    {
    	$address->setContact($this);
        $this->addresses[] = $address;
    
        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \JLM\ContactBundle\Entity\ContactAddress $address
     */
    public function removeAddress(\JLM\ContactBundle\Entity\ContactAddress $address)
    {
    	$address->setContact();
        $this->addresses->removeElement($address);
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