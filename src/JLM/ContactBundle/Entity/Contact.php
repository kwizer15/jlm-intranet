<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JLM\ContactBundle\Model\ContactInterface;
use JLM\ContactBundle\Model\ContactAddressInterface;
use JLM\ContactBundle\Model\ContactPhoneInterface;
use JLM\ContactBundle\Model\ContactEmailInterface;

/**
 * Contact
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * ORM\DiscriminatorMap({
 * 		"person" = "Person",
 *      "company" = "Company"
 */
abstract class Contact implements ContactInterface
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
     * {@inheritdoc}
     */
    public function addEmail(ContactEmailInterface $email)
    {
    	$email->setContact($this);
        $this->emails[] = $email;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEmail(ContactEmailInterface $email)
    {
    	$email->setContact();
        $this->emails->removeElement($email);
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * {@inheritdoc}
     */
    public function addPhone(ContactPhoneInterface $phone)
    {
    	$phone->setContact($this);
        $this->phones[] = $phone;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removePhone(ContactPhoneInterface $phone)
    {
    	$phone->setContact();
        $this->phones->removeElement($phone);
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * {@inheritdoc}
     */
    public function addAddress(ContactAddressInterface $address)
    {
    	$address->setContact($this);
        $this->addresses[] = $address;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAddress(ContactAddressInterface $address)
    {
    	$address->setContact();
        $this->addresses->removeElement($address);
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
    
    
}