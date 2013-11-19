<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Entity\EmailException;

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Email
{
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     * @ORM\Id
     * @Assert\Email
     */
    private $address;

    public function __construct($address)
    {
    	$address = strtolower(trim($address));
    	if (!filter_var($address, FILTER_VALIDATE_EMAIL))
    		throw new EmailException('e-mail address invalid');
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function __toString()
    {
        return $this->address;
    }
}
