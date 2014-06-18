<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContactBundle\Model\PersonInterface;
use JLM\ContactBundle\Model\ContactEmailInterface;
use JLM\ContactBundle\Model\ContactAddressInterface;
use JLM\ContactBundle\Model\ContactPhoneInterface;

/**
 * JLM\ModelBundle\Entity\Person
 *
 * @ORM\Table(name="persons")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\PersonRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * 		"person" = "Person",
 *      "technician" = "Technician",
 * })
 */
class Person implements PersonInterface
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
	 * M. Mme Mlle
	 * @var string $title
	 * 
	 * @ORM\Column(name="title", type="string", length=4)
	 * @Assert\Choice(choices={"M.","Mme","Mlle"})
	 * @Assert\NotNull
	 */
	private $title;
	
    /**
     * @var string $firstName
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    private $firstName;

    /**
     * @var string $lastName
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     * @Assert\Type(type="string")
     */
    private $lastName;
    
    /**
     * @var string $fixedPhone
     * 
     * @ORM\Column(name="fixedPhone",type="string", length=20, nullable=true)
     * @Assert\Regex(pattern="/^0[1-589]\d{8}$/",message="Ce n'est pas un numéro de téléphone fixe valide")
     */
    private $fixedPhone;
    
    /**
     * @var string $mobilePhone
     *
     * @ORM\Column(name="mobilePhone",type="string", length=20, nullable=true)
     * @Assert\Regex(pattern="/^0[67]\d{8}$/",message="Ce n'est pas un numéro de téléphone portable valide")
     */
    private $mobilePhone;

    
    /**
     * @var string $fax
     *
     * @ORM\Column(name="fax",type="string", length=20, nullable=true)
     * @Assert\Regex(pattern="/^0[1-589]\d{8}$/",message="Ce n'est pas un numéro de fax valide")
     */
    private $fax;
    
    /**
     * @var string $email
     *
     * @ORM\Column(name="email",type="string", length=255, nullable=true)
     * @Assert\Email
     */
    private $email;
    
    /**
     * @var string $address
     * 
     * @ORM\OneToOne(targetEntity="JLM\ContactBundle\Model\AddressInterface")
     */
    private $address;
    
    /**
     * @var $role
     *
     * @ORM\Column(name="role",type="string",length=255,nullable=true)
     * @Assert\Type(type="string")
     */
    private $role;
    
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
    	return trim($this->title.' '.$this->lastName.' '.$this->firstName);
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Format phones
     * 
     * @return Person
     */
    public function formatPhones()
    {
    	$this->fixedPhone = str_replace('+33','0',$this->fixedPhone);
    	$this->fixedPhone = str_replace(array('-','/','.',','),'',$this->fixedPhone);
    	$this->mobilePhone = str_replace('+33','0',$this->mobilePhone);
    	$this->mobilePhone = str_replace(array('-','/','.',','),'',$this->mobilePhone);
    	$this->fax = str_replace('+33','0',$this->fax);
    	$this->fax = str_replace(array('-','/','.',','),'',$this->fax);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPhones()
    {
    	return array($this->fixedPhone, $this->mobilePhone, $this->fax);
    }
    
    /**
     * {@inheritdoc}
     */
    public function addPhone(ContactPhoneInterface $phone)
    {
    	$method = 'set' . $this->_getPhoneMethod($phone);
    	$this->$method($phone->__toString());
    	
    	return $this;
    }
    
    private function _getPhoneMethod(ContactPhoneInterface $phone)
    {
    	switch ($phone->getAlias())
    	{
    		case 'fixed':
    			$method = 'FixedPhone';
    			break;
    		case 'mobile':
    			$method = 'MobilePhone';
    			break;
    		default:
    			$method = 'Fax';
    	}
    	
    	return $method;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removePhone(ContactPhoneInterface $phone)
    {
    	$method = $this->_getPhoneMethod($phone);
    	$getMethod = 'get' . $method;
    	if ($this->$getMethod() == $phone->__toString())
    	{
    		$setMethod = 'set' . $method;
    		$this->$setMethod(null);
    	}
    	
    	return $this;
    }
    
    /**
     * Set fixedPhone
     *
     * @param string $fixedPhone
     */
    public function setFixedPhone($fixedPhone)
    {
        $this->fixedPhone = $fixedPhone;
    }

    /**
     * Get fixedPhone
     *
     * @return string 
     */
    public function getFixedPhone()
    {
        return $this->fixedPhone;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
    }

    /**
     * Get mobilePhone
     *
     * @return string 
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
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
     * {@inheritdoc}
     */
    public function addEmail(ContactEmailInterface $email)
    {
    	$this->setEmail($email->__toString());
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeEmail(ContactEmailInterface $email)
    {
    	if ($email->__toString() === $this->getEmail())
    	{
    		$this->setEmail('');
    	}
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEmails()
    {
    	return array($this->email);
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
     * {@inheritdoc}
     */
    public function addAddress(ContactAddressInterface $address)
    {
    	$this->setAddress($address);
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeAddress(ContactAddressInterface $address)
    {
    	if ($address === $this->address)
    	{
    		$this->address = null;
    	}
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAddresses()
    {
    	return array($this->getAddress());
    }
    
    /**
     * Set address
     *
     * @param string $address
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
     * @return string
     */
    public function getAddress()
    {
    	return $this->address;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMainAddress()
    {
    	return $this->getAddress();
    }
    
    /**
     * Set role
     *
     * @param string $role
     * @return SiteContact
     */
    public function setRole($role)
    {
    	$this->role = $role;
    
    	return $this;
    }
    
    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
    	return $this->role;
    }
    
    /**
     * To String
     * 
     * @return string
     */
    public function __toString()
    {
    	return $this->getName();
    }
}