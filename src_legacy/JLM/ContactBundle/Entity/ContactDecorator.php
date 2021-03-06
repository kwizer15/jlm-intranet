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

use JLM\ContactBundle\Model\ContactInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\ContactBundle\Model\AddressInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class ContactDecorator implements ContactInterface
{
    /**
     * Identifier
     *
     * @var int $id
     */
    private $id;

    /**
     * @var ContactInterface $person
     */
    protected $contact;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Get contact
     */
    public function setContact(ContactInterface $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->getContact()->getAddress();
    }

    /**
     * {@inheritdoc}
     */
    public function setAddress(AddressInterface $address)
    {
        return $this->getContact()->setAddress($address);
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->getContact()->getEmail();
    }

    /**
     * {@inheritdoc}
     */
    public function getFax()
    {
        return $this->getContact()->getFax();
    }

    /**
     * {@inheritdoc}
     */
    public function getPhones()
    {
        return $this->getContact()->getPhones();
    }

    public function getPhone()
    {
        return $this->getPhones()[0] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getContact()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getContact()->__toString();
    }

    /**
     *
     * @param string $method
     * @param mixed  $default
     *
     * @return mixed
     */
    private function decoratedGetMethod($method, $default)
    {
        if ($this->getContact() === null) {
            return $default;
        }

        return $this->getContact()->$method();
    }
}
