<?php

namespace JLM\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Model\ContactInterface;

/**
 * Test
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JLM\ContactBundle\Model\ContactInterface")
     */
    private $contact;


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
     * Set contact
     *
     * @param ContactInterface $contact
     * @return Test
     */
    public function setContact(ContactInterface $contact)
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
}
