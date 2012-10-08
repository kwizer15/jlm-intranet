<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Interlocutor
 *
 * @ORM\Table(name="interlocutors")
 * @ORM\Entity
 */
class Interlocutor extends Person
{
    /**
     * @var string $role
     *
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * @var Trustee $trustee
     * 
     * @ORM\ManyToOne(targetEntity="Trustee", inversedBy="interlocutors")
     */
    private $trustee;

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