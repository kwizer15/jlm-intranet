<?php
namespace JLM\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JLM\ModelBundle\Entity\Person;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\JLM\ModelBundle\Entity\Person")
     */
    private $person;
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set person
     *
     * @param Person $person
     * @return User
     */
    public function setPerson(\JLM\ModelBundle\Entity\Person $person = null)
    {
        $this->person = $person;
    
        return $this;
    }

    /**
     * Get person
     *
     * @return JLM\UserBundle\Entity\JLMModelBundle:Person 
     */
    public function getPerson()
    {
        return $this->person;
    }
}