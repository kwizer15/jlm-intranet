<?php
namespace JLM\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Model\PersonInterface;

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
     * @ORM\OneToOne(targetEntity="JLM\ContactBundle\Model\PersonInterface")
     */
    private $person;
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set person
     *
     * @param PersonInterface $person
     * @return User
     */
    public function setPerson(PersonInterface $person = null)
    {
        $this->person = $person;
    
        return $this;
    }

    /**
     * Get person
     *
     * @return PersonInterface
     */
    public function getPerson()
    {
        return $this->person;
    }
}