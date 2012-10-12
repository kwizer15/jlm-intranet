<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Employee
 *
 * @ORM\Table(name="employees")
 * @ORM\Entity
 */
class Employee extends Person
{
    /**
     * @var string $role
     *
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * @var Company[] $companies
     * 
     * @ORM\ManyToMany(targetEntity="Company", inversedBy="employees")
     * @ORM\JoinTable(name="employees_companies")
     */
    private $companies;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
    	$this->companies = new ArrayCollection;
    }

    /**
     * Set role
     *
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
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
     * Add companies
     *
     * @param JLM\ModelBundle\Entity\Company $companies
     */
    public function addCompany(\JLM\ModelBundle\Entity\Company $companies)
    {
        $this->companies[] = $companies;
    }

    /**
     * Get companies
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCompanies()
    {
        return $this->companies;
    }
}