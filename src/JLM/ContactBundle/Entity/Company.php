<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\ModelBundle\Entity\StringModel;
use JLM\ContactBundle\Model\CompanyInterface;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContactBundle\Model\PersonInterface;


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
class Company extends StringModel implements CompanyInterface
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
	 * @Assert\Regex(pattern="/^0[1-9]\d{8}$/",message="Ce n'est pas un numéro de téléphone fixe valide")
	 */
	private $phone;
	
	/**
	 * @var string $fax
	 *
	 * @ORM\Column(name="fax",type="string",length=20, nullable=true)
	 * @Assert\Regex(pattern="/^0[1-589]\d{8}$/",message="Ce n'est pas un numéro de fax valide")
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
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        
        return $this;
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
     * @return self
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
        
        return $this;
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
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        
        return $this;
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
     * @param AddressInterface $address
     * @return self
     */
    public function setAddress(AddressInterface $address)
    {
        $this->address = $address;
        
        return $this;
    }

    /**
     * Get address
     *
     * @return AddressInterface
     */
    public function getAddress()
    {
        return $this->address;
    }

    
    /**
     * Add contacts
     *
     * @param PersonInterface $contacts
     * @return bool
     */
    public function addContact(PersonInterface $contacts)
    {
    	$this->contacts[] = $contacts;
    	
    	return true;
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