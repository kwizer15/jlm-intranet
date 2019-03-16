<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Tests\Entity;

use JLM\ModelBundle\Entity\Site;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SiteTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Country
     */
    protected $entity;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new Site();
    }

    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
    }

    public function testAddress()
    {
        $address = $this->createMock('JLM\ContactBundle\Model\AddressInterface');
        $this->assertSame($this->entity, $this->entity->setAddress($address));
        $this->assertSame($address, $this->entity->getAddress());
    }

    public function testLodge()
    {
        $address = $this->createMock('JLM\ContactBundle\Model\AddressInterface');
        $this->assertSame($this->entity, $this->entity->setLodge($address));
        $this->assertSame($address, $this->entity->getLodge());
    }

    public function testAddContact()
    {
        $person = $this->createMock('JLM\ModelBundle\Entity\SiteContact');
        $this->assertTrue($this->entity->addContact($person));
        $this->assertCount(1, $this->entity->getContacts());
        $this->assertTrue($this->entity->removeContact($person));
        $this->assertCount(0, $this->entity->getContacts());
    }
}
