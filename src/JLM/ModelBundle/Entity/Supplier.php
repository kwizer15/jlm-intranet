<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Supplier
 *
 * @ORM\Table(name="suppliers")
 * @ORM\Entity
 */
class Supplier
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Phone $phone
     *
     * @ORM\OneToOne(targetEntity="Phone")
     */
    private $phone;
    
    /**
     * @var Email $email
     *
     * @ORM\OneToOne(targetEntity="Email")
     */
    private $email;
    
    /**
     * @var Empoyee[] $employees
     *
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="supplier")
     */
    private $employees;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->employees = new ArrayCollection;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param JLM\ModelBundle\Entity\Phone $phone
     */
    public function setPhone(\JLM\ModelBundle\Entity\Phone $phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return JLM\ModelBundle\Entity\Phone 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param JLM\ModelBundle\Entity\Email $email
     */
    public function setEmail(\JLM\ModelBundle\Entity\Email $email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return JLM\ModelBundle\Entity\Email 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add employees
     *
     * @param JLM\ModelBundle\Entity\Employee $employees
     */
    public function addEmployee(\JLM\ModelBundle\Entity\Employee $employees)
    {
        $this->employees[] = $employees;
    }

    /**
     * Get employees
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEmployees()
    {
        return $this->employees;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->name;
    }
}