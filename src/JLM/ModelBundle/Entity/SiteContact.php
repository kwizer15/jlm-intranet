<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\ContactBundle\Model\PersonInterface;
use JLM\CondominiumBundle\Model\AdministratorMemberInterface;
use JLM\CondominiumBundle\Model\AdministratorInterface;

/**
 * JLM\ModelBundle\Entity\SiteContact
 *
 * @ORM\Table(name="site_contacts")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\SiteContactRepository")
 */
class SiteContact implements AdministratorMemberInterface, PersonInterface
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
     * @deprecated
     * @param UnionCouncilInterface $site
     * @return self
     */
    public function setSite(AdministratorInterface $site = null)
    {
        return $this->setAdministrator($site);
    }

    /**
     * Get site
     * @deprecated
     * @return JLM\ModelBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->getAdministrator();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAdministrator()
    {
        return $this->site;
    }

    /**
     * Set union council
     *
     * @param UnionCouncilInterface $unioncouncil
     * @return SiteContact
     */
    public function setAdministrator(AdministratorInterface $unioncouncil = null)
    {
        $this->site = $unioncouncil;
    
        return $this;
    }
    
    /**
     * Set person
     *
     * @param PersonInterface $person
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
     * @return PersonInterface
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
        $this->role = $role;
    
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
        return $this->role;
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

    // Person Decorators
    
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->getPerson()->getTitle();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->getPerson()->getFirstName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->getPerson()->getLastName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFixedPhone()
    {
        return $this->getPerson()->getFixedPhone();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMobilePhone()
    {
        return $this->getPerson()->getMobilePhone();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFax()
    {
        return $this->getPerson()->getFax();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->getPerson()->getEmail();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->getPerson()->getAddress();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getPerson()->getName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getPerson()->__toString();
    }
}