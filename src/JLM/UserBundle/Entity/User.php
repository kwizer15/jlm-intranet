<?php
namespace JLM\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Model\ContactInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser implements ContactInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="JLM\ContactBundle\Model\ContactInterface")
     */
    private $contact;
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set contact
     *
     * @param ContactInterface $contact
     * @return self
     */
    public function setContact(ContactInterface $contact = null)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return ContactInterface
     */
    public function getContact()
    {
        return $this->person;
    }
}