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

use JLM\ContactBundle\Model\PersonInterface;
use JLM\CommerceBundle\Model\QuoteRecipientInterface;
use JLM\AskBundle\Model\ContactInterface;   // @todo to remove, use a decorator into AskBundle

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Person extends Contact implements PersonInterface, QuoteRecipientInterface, ContactInterface
{
    /**
     * M. Mme Mlle
     *
     * @var string $title
     */
    private $title;

    /**
     * @var string $firstName
     */
    private $firstName;

    /**
     * @var string $lastName
     */
    private $lastName;

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return trim($this->title . ' ' . trim($this->lastName . ' ' . $this->firstName));
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        parent::setName(trim($this->lastName . ' ' . $this->firstName));

        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getMobilePhone()
    {
        return $this->getPhoneNumber('Portable');
    }

    /**
     * {@inheritdoc}
     */
    public function getFixedPhone()
    {
        return $this->getPhoneNumber('Principal');
    }

    /**
     *
     * @return self
     */
    public function attributeName()
    {
        return $this->setName('');
    }
}
