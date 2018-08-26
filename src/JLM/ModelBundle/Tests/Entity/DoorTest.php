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

use JLM\ModelBundle\Entity\Door;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DoorTest extends \PHPUnit_Framework_TestCase
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
        $this->entity = new Door;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
    }
    
    public function testAdministrator()
    {
        $admin = $this->getMock('JLM\CondominiumBundle\Model\AdministratorInterface');
        $this->assertSame($this->entity, $this->entity->setAdministrator($admin));
        $this->assertSame($admin, $this->entity->getAdministrator());
    }
    
    public function testParts()
    {
        $product = $this->getMock('JLM\ProductBundle\Model\ProductInterface');
        $this->assertCount(0, $this->entity->getParts());
        $this->assertTrue($this->entity->addPart($product));
        $this->assertCount(1, $this->entity->getParts());
        $this->assertTrue($this->entity->removePart($product));
        $this->assertCount(0, $this->entity->getParts());
    }
}
