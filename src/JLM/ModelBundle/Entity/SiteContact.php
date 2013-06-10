<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\SiteContact
 *
 * @ORM\Table(name="site_contacts")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\SiteContactRepository")
 */
class SiteContact
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
	 * @Assert\Valid
	 * @Assert\NotNull
	 */
	private $site;
	
	/**
	 * @var $person
	 *
	 * @ORM\ManyToOne(targetEntity="Person")
	 * @Assert\Valid
	 * @Assert\NotNull
	 */
	private $person;
	
	/**
	 * @var $role
	 * 
	 * @ORM\Column(name="role",type="string",length=255)
	 * @Assert\Type(type="string")
	 * @Assert\NotBlank
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
    public function setPerson(\JLM\ModelBundle\Entity\Person $person = null)
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
}