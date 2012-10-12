<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
class Company extends Contact
{
	/**
	 * @var string $name
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;
	
	/**
	 * @var Employee[] $employees
	 *
	 * @ORM\ManyToMany(targetEntity="Employee", mappedBy="companies")
	 */
	private $employees;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->employees = new ArrayCollection;
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
}