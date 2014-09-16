<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\PersonInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
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
     * @ORM\OneToOne(targetEntity="Address")
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
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        
        return $this;
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
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        
        return $this;
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
    	return trim($this->title.' '.trim($this->lastName.' '.$this->firstName));
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
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
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
     * @return self
     */
    public function formatPhones()
    {
    	$this->fixedPhone = str_replace('+33','0',$this->fixedPhone);
    	$this->fixedPhone = str_replace(array('-','/','.',','),'',$this->fixedPhone);
    	$this->mobilePhone = str_replace('+33','0',$this->mobilePhone);
    	$this->mobilePhone = str_replace(array('-','/','.',','),'',$this->mobilePhone);
    	$this->fax = str_replace('+33','0',$this->fax);
    	$this->fax = str_replace(array('-','/','.',','),'',$this->fax);
    	
    	return $this;
    }
    
    /**
     * Set fixedPhone
     *
     * @param string $fixedPhone
     * @return self
     */
    public function setFixedPhone($fixedPhone)
    {
        $this->fixedPhone = $fixedPhone;
        
        return $this;
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
     * @return self
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
        
        return $this;
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
     * @param string $address
     * @return self
     */
    public function setAddress($address)
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
     * Set role
     *
     * @param string $role
     * @return self
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