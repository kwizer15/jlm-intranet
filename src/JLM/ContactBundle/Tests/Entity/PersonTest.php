<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Person;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PersonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Person
     */
    protected $entity;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new Person();
    }

    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ContactBundle\Model\PersonInterface', $this->entity);
        $this->assertNull($this->entity->getId());
    }

    public function getAttributes()
    {
        return [
            [
                'Title',
                'M.',
            ],
            [
                'Title',
                'Mme',
            ],
            [
                'FirstName',
                'Foo',
            ],
            [
                'LastName',
                'Foo',
            ],
            [
                'Email',
                'commerce@jlm-entreprise.fr',
            ],
            [
                'Address',
                $this->getMock('JLM\ContactBundle\Model\AddressInterface'),
            ],
        ];
    }

    /**
     * Test getters and setters
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @dataProvider getAttributes
     */
    public function testGettersSetters($attribute, $value)
    {
        $getter = 'get' . $attribute;
        $setter = 'set' . $attribute;
        $this->assertSame($this->entity, $this->entity->$setter($value));
        $this->assertSame($value, $this->entity->$getter());
    }

    public function getAdderRemover()
    {
        return [
            [
                'Phone',
                'Phones',
                $this->getMock('JLM\ContactBundle\Model\ContactPhoneInterface'),
            ],
        ];
    }

    /**
     * @dataProvider getAdderRemover
     */
    public function testAdderRemover($attribute, $attributes, $value)
    {
        $getters = 'get' . $attributes;
        $adder = 'add' . $attribute;
        $remover = 'remove' . $attribute;
        $this->assertCount(0, $this->entity->$getters());
        $this->assertFalse($this->entity->$remover($value));
        $this->assertTrue($this->entity->$adder($value));
        $this->assertCount(1, $this->entity->$getters());
        $this->assertTrue($this->entity->$remover($value));
        $this->assertCount(0, $this->entity->$getters());
    }

    public function getNames()
    {
        return [
            [
                'M.',
                'Emmanuel',
                'Bernaszuk',
                'M. Bernaszuk Emmanuel',
            ],
            [
                '',
                'Emmanuel',
                'Bernaszuk',
                'Bernaszuk Emmanuel',
            ],
            [
                'M.',
                '',
                'Bernaszuk',
                'M. Bernaszuk',
            ],
            [
                'M.',
                'Emmanuel',
                '',
                'M. Emmanuel',
            ],
            [
                '',
                '',
                '',
                '',
            ],
        ];
    }

    /**
     * @dataProvider getNames
     *
     * @param string $title
     * @param string $firstName
     * @param string $lastName
     * @param string $out
     */
    public function testName($title, $firstName, $lastName, $out)
    {
        $this->assertSame($this->entity, $this->entity->setTitle($title));
        $this->assertSame($this->entity, $this->entity->setFirstName($firstName));
        $this->assertSame($this->entity, $this->entity->setLastName($lastName));
        $this->assertSame($out, $this->entity->getName());
        $this->assertSame($out, $this->entity->__toString());
    }
}
