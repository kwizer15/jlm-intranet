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

use JLM\ContactBundle\Entity\CorporationContact;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CorporationContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->person = $this->getMock('JLM\ContactBundle\Model\PersonInterface');
        $this->entity = new CorporationContact($this->person);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ContactBundle\Model\PersonInterface', $this->entity);
        $this->assertNull($this->entity->getManager());
    }
    
    public function testCorporation()
    {
        $corpo = $this->getMock('JLM\ContactBundle\Model\CorporationInterface');
        $this->assertSame($this->entity, $this->entity->setCorporation($corpo));
        $this->assertSame($corpo, $this->entity->getCorporation());
    }
    
    public function getPositions()
    {
        return array(
        	array('Gestionnaire'),
            array('Assistante'),
        );
    }
    
    /**
     * @dataProvider getPositions
     * @param string $position
     */
    public function testPosition($position)
    {
        $this->assertSame($this->entity, $this->entity->setPosition($position));
        $this->assertSame($position, $this->entity->getPosition());
    }
    
    public function getManagers()
    {
        return array(
        	array($this->getMock('JLM\ContactBundle\Model\CorporationContactInterface'), true),
            array(null, false),
        );
    }
    
    /**
     * @dataProvider getManagers
     * @param null|JLM\ContactBundle\Model\CorporationContactInterface $manager
     * @param bool $has
     */
    public function testManager($manager, $has)
    {
        $this->assertSame($this->entity, $this->entity->setManager($manager));
        $this->assertSame($manager, $this->entity->getManager());
        $this->assertSame($has, $this->entity->hasManager());
    }
    
    public function getDecoFunctions()
    {
        return array(
        	array('getTitle', 'Foo'),
            array('getFirstName', 'Foo'),
            array('getLastName', 'Foo'),
            array('getName', 'Foo'),
            array('getFixedPhone', 'Foo'),
            array('getMobilePhone', 'Foo'),
            array('getAddress', 'Foo'),
            array('getFax', 'Foo'),
            array('getEmail', 'Foo'),
            array('__toString', 'Foo'),
        );
    }
    
    /**
     * @dataProvider getDecoFunctions
     * @param string $func
     * @param string $returnValue
     */
    public function testDecoratorFunctions($func, $returnValue)
    {
        $this->person->expects($this->once())->method($func)->will($this->returnValue($returnValue));
        $this->assertSame($returnValue, $this->entity->$func());
    }
}