<?php

/*
 * This file is part of the installation-bundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\InstallationBundle\Tests\Entity;

use JLM\InstallationBundle\Entity\Bay;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BayTest extends \PHPUnit_Framework_TestCase
{
    private $entity;
    
    protected function setUp()
    {
        $this->property = $this->getMock('JLM\CollectiveHousingBundle\Model\PropertyInterface');
        $this->part = $this->getMock('JLM\InstallationBundle\Model\PartInterface');
        $this->entity = new Bay($this->property, $this->part);
    }
    
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\InstallationBundle\Model\BayInterface',$this->entity);
    }
    
    public function testGetPart()
    {
        $this->assertSame($this->part, $this->entity->getPart());
    }
    
    public function testGetProperty()
    {
        $this->assertSame($this->property, $this->entity->getProperty());
    }
}