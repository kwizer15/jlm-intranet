<?php

/*
 * This file is part of the JLMAskBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\AskBundle\Tests\Entity;

use JLM\AskBundle\Entity\CommunicationMeans;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CommunicationMeansTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommunicationMeans
     */
    protected $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new CommunicationMeans;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\AskBundle\Model\CommunicationMeansInterface', $this->entity);
        $this->assertNull($this->entity->getId());
    }
    
    public function getGetterSetter()
    {
        return [
                [
                 'Name',
                 'Foo',
                ],
               ];
    }
    
    /**
     * @dataProvider getGetterSetter
     */
    public function testGetterSetter($attribute, $value)
    {
        $getter = 'get'.$attribute;
        $setter = 'set'.$attribute;
        $this->assertSame($this->entity, $this->entity->$setter($value));
        $this->assertSame($value, $this->entity->$getter());
    }
    
    public function testToString()
    {
        $value = 'Foo';
        $this->entity->setName($value);
        $this->assertSame($value, $this->entity->__toString());
    }
}
