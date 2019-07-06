<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CondominiumBundle\Tests\Entity;

use JLM\CondominiumBundle\Entity\Manager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ManagerTest extends \PHPUnit\Framework\TestCase
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
        $this->contact = $this->createMock('JLM\ContactBundle\Model\ContactInterface');
        $this->entity = new Manager();
        $this->entity->setContact($this->contact);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\CondominiumBundle\Model\ManagerInterface', $this->entity);
    }
    
    public function getNames()
    {
        return array(
            array('Foo', 'Foo'),
        );
    }
    
    /**
     * @dataProvider getNames
     * @param string $in
     * @param string $out
     */
    public function testName($in, $out)
    {
        $this->contact->expects($this->once())->method('getName')->will($this->returnValue($in));
        $this->assertSame($out, $this->entity->getName());
    }
}