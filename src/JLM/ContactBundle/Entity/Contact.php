<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JLM\ContactBundle\Model\ContactInterface;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContactBundle\Model\ContactPhoneInterface;
use JLM\CoreBundle\Entity\UploadDocument;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class Contact implements ContactInterface
{
    /**
     * @var int
     * Ehancement
     */
    private $id;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var Address $address
     */
    private $address;

    /**
     * @var ContactPhoneInterface[]
     */
    private $phones;

    /**
     * @var email $email
     */
    private $email;

    /**
     * @var bool $active
     */
    private $active = true;

    /**
     * @var UploadDocument $image
     */
    private $image;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phones = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        $shorts = explode('\\', get_class($this));
        $short = $shorts[sizeof($shorts) - 1];

        return strtolower($short);
    }

    /**
     * Set text
     *
     * @param string $text
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add a phone
     *
     * @param ContactPhoneInterface $phone
     *
     * @return bool
     */
    public function addPhone(ContactPhoneInterface $phone)
    {
        return $this->phones->add($phone);
    }

    /**
     * Remove a phone
     *
     * @param ContactPhoneInterface
     *
     * @return bool
     */
    public function removePhone(ContactPhoneInterface $phone)
    {
        return $this->phones->removeElement($phone);
    }

    /**
     * Get phones
     *
     * @return array
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param AddressInterface $address
     *
     * @return self
     */
    public function setAddress(AddressInterface $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return AddressInterface
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set active
     *
     * @param bool $active
     *
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->getActive();
    }

    public function setImage(UploadDocument $image)
    {
        $this->image = $image;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * {@inheritdoc}
     */
    public function getFax()
    {
        return $this->getPhoneNumber('Fax');
    }

    /**
     * Get the phone number by label
     *
     * @param string $type
     *
     * @return NULL|string
     */
    protected function getPhoneNumber($type)
    {
        $phones = $this->getPhones();
        foreach ($phones as $phone) {
            if ($phone->getLabel() == $type) {
                return $phone->getNumber();
            }
        }

        return null;
    }
}
