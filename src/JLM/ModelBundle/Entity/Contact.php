<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collection\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Contact
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * 		"person" = "Person",
 * 		"company" = "Company"
 * })
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
	 * @var Address[] $addresses
	 * 
	 * @ORM\ManyToMany(targetEntity="Address")
	 * @ORM\JoinTable(name="contact_addresses",
	 * 		joinColumns={@ORM/JoinColumn(name="contact_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM/JoinColumn(name="address_id", referencedColumnName="id", unique=true)}
	 * )
	 */
    private $addresses;
    
    /**
     * @var Phone[] $phones
     * 
     * @ORM\OneToMany(targetEntity="Phone")
     * @ORM\JoinTable(name="contact_phones",
	 * 		joinColumns={@ORM/JoinColumn(name="contact_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM/JoinColumn(name="phone_id", referencedColumnName="id", unique=true)}
	 * )
     */
    private $phones;
    
    /**
     * @var Email[] $emails
     * 
     * @ORM\OneToMany(targetEntity="Email")
     * @ORM\JoinTable(name="contact_emails",
     * 		joinColumns={@ORM/JoinColumn(name="contact_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@ORM/JoinColumn(name="email_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $emails;
    
    /**
     * Construct
     */
    public function __construct()
    {
    	$this->addresses = new ArrayCollection;
    	$this->phones = new ArrayCollection;
    	$this->emails = new ArrayCollection;
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
    
    abstract public function getName();
}