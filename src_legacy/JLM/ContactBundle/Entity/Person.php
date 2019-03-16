<?php

namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\PersonInterface;
use JLM\CommerceBundle\Model\QuoteRecipientInterface;
use JLM\AskBundle\Model\ContactInterface;   // TODO: to remove, use a decorator into AskBundle

class Person extends Contact implements PersonInterface, QuoteRecipientInterface, ContactInterface
{
    /**
     * M. Mme Mlle
     *
     * @var string $title
     */
    private $title = '';

    /**
     * @var string $firstName
     */
    private $firstName = '';

    /**
     * @var string $lastName
     */
    private $lastName = '';

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Person
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Person
     */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return trim($this->title . ' ' . trim($this->lastName . ' ' . $this->firstName));
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name): self
    {
        parent::setName(trim($this->lastName . ' ' . $this->firstName));

        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Person
     */
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getMobilePhone(): ?string
    {
        return $this->getPhoneNumber('Portable');
    }

    /**
     * {@inheritdoc}
     */
    public function getFixedPhone(): ?string
    {
        return $this->getPhoneNumber('Principal');
    }

    /**
     *
     * @return PErson
     */
    public function attributeName(): self
    {
        return $this->setName('');
    }
}
