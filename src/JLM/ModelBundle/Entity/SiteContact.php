<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\ContactBundle\Model\PersonInterface;
use JLM\ContactBundle\Model\ContactEmailInterface;
use JLM\ContactBundle\Model\ContactAddressInterface;
use JLM\ContactBundle\Model\ContactPhoneInterface;

/**
 * JLM\ModelBundle\Entity\SiteContact
 *
 * @ORM\Table(name="site_contacts")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\SiteContactRepository")
 */
class SiteContact implements PersonInterface
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
	 * @var $sites
	 * 
	 * @ORM\ManyToOne(targetEntity="Site", inversedBy="contacts")
	 * @Assert\NotNull
	 */
	private $site;
	
	/**
	 * @var $person
	 *
	 * @ORM\ManyToOne(targetEntity="JLM\ContactBundle\Model\PersonInterface")
	 * @Assert\Valid
	 * @Assert\NotNull
	 */
	private $person;
	
	/**
	 * @var $role
	 * 
	 * @ORM\Column(name="role",type="string",length=255,nullable=true)
	 * @Assert\Type(type="string")
	 */
	private $role;
   
	
//	/**
//	 * @var string $professionnalPhone
//	 *
//	 * ORM\Column(name="professionnalPhone", type="string", length=20, nullable=true)
//	 */
//	private $professionnalPhone;
	
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
     * Set site
     *
     * @param JLM\ModelBundle\Entity\Site $site
     * @return SiteContact
     */
    public function setSite(\JLM\ModelBundle\Entity\Site $site = null)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get site
     *
     * @return JLM\ModelBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set person
     *
     * @param JLM\ModelBundle\Entity\Person $person
     * @return SiteContact
     */
    public function setPerson(PersonInterface $person = null)
    {
        $this->person = $person;
    
        return $this;
    }

    /**
     * Get person
     *
     * @return JLM\ModelBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return SiteContact
     * @deprecated
     */
    public function setRole($role)
    {
        $this->person->setRole($role);
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string
     * @deprecated
     */
    public function getRole()
    {
        return $this->person->getRole();
    }
    
    /**
     * Get old role
     *
     * @return string
     * @deprecated
     */
    public function getOldRole()
    {
    	return $this->role;
    }
    
//    /**
//     * Set professionnalPhone
//     *
//     * @param string $professionnnalPhone
//     */
//    public function setProfessionnalPhone($professionnalPhone)
//    {
//    	$this->professionnalPhone = $professionnalPhone;
//    }
//    
//    /**
//     * Get professionnalPhone
//     *
//     * @return string
//     */
//    public function getProfessionnalPhone()
//    {
//    	return $this->professionnalPhone;
//    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
    	return $this->person->getFirstName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
    	return $this->person->getLastName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
    	return $this->person->getName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
    	return $this->person->__toString();
    }
    
    /**
     * {@inheritdoc}
     */
    public function addEmail(ContactEmailInterface $email)
    {
    	$this->person->addEmail($email);
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeEmail(ContactEmailInterface $email)
    {
    	$this->person->removeEmail($email);
    	 
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEmails()
    {
    	return $this->person->getEmails();
    }
    
    /**
     * {@inheritdoc}
     */
    public function addAddress(ContactAddressInterface $address)
    {
    	$this->person->addAddress($address);
    	 
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeAddress(ContactAddressInterface $address)
    {
    	$this->person->removeAddress($address);
    
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAddresses()
    {
    	return $this->person->getAddresses();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMainAddress()
    {
    	return $this->person->getMainAddress();
    }
    
    /**
     * {@inheritdoc}
     */
    public function addPhone(ContactPhoneInterface $phone)
    {
    	$this->person->addPhone($phone);
    
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removePhone(ContactPhoneInterface $phone)
    {
    	$this->person->removePhone($phone);
    
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPhones()
    {
    	return $this->person->getPhones();
    }
}