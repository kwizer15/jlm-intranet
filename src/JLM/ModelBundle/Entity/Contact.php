<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Contact
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\ContactRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * 		"person" = "Person",
 * 		"company" = "Company"
 *      })
 */
abstract class Contact
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Telephones
     * @var Phone[] $phones
     * 
     * @ORM\ManyToMany(targetEntity="Phone",cascade={"all"})
     * @ORM\JoinTable(name="contacts_phones",
     *      joinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="phone_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $phones;
    
    /**
     * Adresses
     * @var Address[] $addresses
     *
     * @ORM\ManyToMany(targetEntity="Address",cascade={"all"})
     * @ORM\JoinTable(name="contacts_addresses",
     *      joinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="address_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $addresses;
    
    /**
     * Email
     * @var Email[] $emails
     *
     * @ORM\ManyToMany(targetEntity="Email",cascade={"all"})
     * @ORM\JoinTable(name="contacts_emails",
     *      joinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="email_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $emails;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->phones    = new ArrayCollection;
    	$this->addresses = new ArrayCollection;
    	$this->emails    = new ArrayCollection;
    }

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
 	 * Get name
 	 * 
 	 * @return string
 	 */
    abstract public function getName();
    
    /**
     * To String
     * 
     * @return string
     */
    public function __toString()
    {
    	return $this->getName();
    }

    /**
     * Add phones
     *
     * @param JLM\ModelBundle\Entity\Phone $phones
     */
    public function addPhone(\JLM\ModelBundle\Entity\Phone $phones)
    {
        $this->phones[] = $phones;
    }

    /**
     * Get phones
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Add addresses
     *
     * @param JLM\ModelBundle\Entity\Address $addresses
     */
    public function addAddress(\JLM\ModelBundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;
    }

    /**
     * Get addresses
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add emails
     *
     * @param JLM\ModelBundle\Entity\Email $emails
     */
    public function addEmail(\JLM\ModelBundle\Entity\Email $emails)
    {
        $this->emails[] = $emails;
    }

    /**
     * Get emails
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }
}