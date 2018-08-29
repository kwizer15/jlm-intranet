<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Tests\Entity;

use JLM\DailyBundle\Entity\PartFamily;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PartFamilyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Country
     */
    protected $entity;
    
    protected function setUp()
    {
        $this->entity = new PartFamily();
    }
    
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\DailyBundle\Model\PartFamilyInterface', $this->entity);
        $this->assertNull($this->entity->getId());
        $this->assertNull($this->entity->getName());
    }
    
    /**
     * Valid codes
     * @return array
     */
    public function getNames()
    {
        return [
                [
                 'Guidage',
                 'Guidage',
                ],
               ];
    }
    
    /**
     * @dataProvider getNames
     */
    public function testName($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setName($in));
        $this->assertSame($out, $this->entity->getName());
    }
    
    /**
     * @dataProvider getNames
     */
    public function testToString($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setName($in));
        $this->assertSame($out, $this->entity->__toString());
    }
}
