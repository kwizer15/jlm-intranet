<?php

/*
 * This file is part of the jlm-model package.
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
    private $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new Door();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\InstallationBundle\Model\BayInterface',$this->entity);
        $this->assertInstanceOf('JLM\InstallationBundle\Model\PartInterface',$this->entity);
    }
    
    public function testIsBlocked()
    {
        $site = $this->getMock('JLM\CollectiveHousingBundle\Model\PropertyInterface');
        $site->expects($this->once())->method('isBlocked')->will($this->returnValue(true));
        $this->entity->setSite($site);
        $this->assertTrue($this->entity->isBlocked());
    }
    
}