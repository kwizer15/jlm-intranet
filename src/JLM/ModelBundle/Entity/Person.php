<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Person
 *
 * @ORM\Table(name="persons")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * 		"person" = "Person",
 * 		"interlocutor" = "Interlocutor",
 *      "collaborator" = "Collaborator"
 * })
 */
class Person
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
     * @var string $firstName
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string $lastName
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;
    
    /**
     * @var Phone[] $phones
     * 
     * @ORM\ManyToMany(targetEntity="Phone")
     * @ORM\JoinTable(name="person_phones",
	 * 		joinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM\JoinColumn(name="phone_id", referencedColumnName="id", unique=true)}
	 * )
     */
    private $phones;
    
    /**
     * @var Email[] $emails
     * 
     * @ORM\ManyToMany(targetEntity="Email")
     * @ORM\JoinTable(name="person_emails",
     * 		joinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="email_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $emails;

    
    /**
     * Construct
     */
    public function __construct()
    {
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

    /**
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * Get name
     * 
     * @return string
     */
    public function getName()
    {
    	return $this->firstName.' '.$this->lastName;
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