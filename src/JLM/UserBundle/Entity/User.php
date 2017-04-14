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
        return $this->contact;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        if (null === $this->getContact())
        {
            return parent::__toString();
        }

        return $this->getContact()->__toString();
    }

    /**
     * {@inheritdoc}
     */
    public function getFax()
    {
        return $this->contact->getFax();
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->contact->getAddress();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->contact->getName();
    }
}
