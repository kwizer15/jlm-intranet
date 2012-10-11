<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var Supplier $supplier
     * 
     * @ORM\ManyToOne(targetEntity="Supplier", inversedBy="employees")
     */
    private $supplier;

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
     * Set supplier
     *
     * @param JLM\ModelBundle\Entity\Supplier $supplier
     */
    public function setSupplier(\JLM\ModelBundle\Entity\Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * Get supplier
     *
     * @return JLM\ModelBundle\Entity\Supplier 
     */
    public function getSupplier()
    {
        return $this->supplier;
    }
}