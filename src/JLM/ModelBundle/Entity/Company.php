<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Company
 *
 * @ORM\Table(name="companies")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * 		"trustee" = "Trustee",
 * 		"supplier" = "Supplier",
 * 		"company" = "Company"
 *      })
 */
class Company extends StringModel
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
	 * @var Address $address
	 * 
	 * @ORM\OneToOne(targetEntity="Address")
	 * @Assert\NotNull
	 * @Assert\Valid
	 */
	private $address;
	
	/**
	 * @var string $phone
	 * 
	 * @ORM\Column(name="phone",type="string",length=20)
	 * @Assert\NotNull
	 * @Assert\Type(type="string")
	 */
	private $phone;
	
	/**
	 * @var string $fax
	 *
	 * @ORM\Column(name="fax",type="string",length=20, nullable=true)
	 * @Assert\Type(type="string")
	 */
	private $fax;
	
	/**
	 * @var email $email
	 *
	 * @ORM\Column(name="email",type="string",length=255, nullable=true)
	 * @Assert\Email
	 */
	private $email;
	
	
	/**
	 * @var Person[] $contacts
	 *
	 * @ORM\ManyToMany(targetEntity="Person",cascade={"all"})
	 * @ORM\JoinTable(name="companies_contacts",
	 *      joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id", unique=true)}
	 *      )
	 * @Assert\Valid(traverse="true")
	 */
	private $contacts;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->contacts = new ArrayCollection;
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
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param JLM\ModelBundle\Entity\Address $address
     */
    public function setAddress(\JLM\ModelBundle\Entity\Address $address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return JLM\ModelBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    
    /**
     * Add contacts
     *
     * @param JLM\ModelBundle\Entity\Person $contacts
     */
    public function addContact(\JLM\ModelBundle\Entity\Person $contacts)
    {
    	$this->contacts[] = $contacts;
    }
    
    /**
     * Get contacts
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
    	return $this->contacts;
    }
}