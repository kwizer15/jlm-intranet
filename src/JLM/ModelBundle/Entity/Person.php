<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Person
 *
 * @ORM\Table(name="persons")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * 		"person" = "Person",
 *      "employee" = "Employee"
 * })
 */
class Person extends Contact
{
	
	/**
	 * M. Mme Mlle
	 * @var string $title
	 * 
	 * @ORM\Column(name="title", type="string", length=4)
	 */
	private $title;
	
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
     * @var string $fixedPhone
     * 
     * @ORM\Column(name="fixedPhone",type="string", length=20)
     */
    private $fixedPhone;
    
    /**
     * @var string $mobilePhone
     *
     * @ORM\Column(name="mobilePhone",type="string", length=20)
     */
    private $mobilePhone;
    
    /**
     * @var string $professionnalPhone
     *
     * @ORM\Column(name="professionnnalPhone", type="string", length=20)
     */
    private $professionnnalPhone;
    
    /**
     * @var string $fax
     *
     * @ORM\Column(name="fax",type="string", length=20)
     */
    private $fax;
    
    /**
     * @var string $email
     *
     * @ORM\Column(name="email",type="string", length=20)
     */
    private $email;
    
    /**
     * @var string $role
     *
     * @ORM\Column(name="role", type="string", length=255)
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
    	return $this->title.' '.$this->firstName.' '.$this->lastName;
    }
}