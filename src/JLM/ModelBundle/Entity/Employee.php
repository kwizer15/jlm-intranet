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
     * @var string $professionnalPhone
     * 
     * @ORM\Column(name="professionnnalPhone", type="string", length=20)
     */
    private $professionnnalPhone;

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
}