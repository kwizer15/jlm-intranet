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
class CorporationContactTest extends \PHPUnit\Framework\TestCase
{
    private $person;
    private $entity;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->person = $this->createMock('JLM\ContactBundle\Model\PersonInterface');
        $this->entity = new CorporationContact();
        $this->entity->setPerson($this->person);
    }

    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ContactBundle\Model\PersonInterface', $this->entity);
    }

    public function testCorporation()
    {
        $corpo = $this->createMock('JLM\ContactBundle\Model\CorporationInterface');
        $this->assertSame($this->entity, $this->entity->setCorporation($corpo));
        $this->assertSame($corpo, $this->entity->getCorporation());
    }

    public function getPositions()
    {
        return [
            ['Gestionnaire'],
            ['Assistante'],
        ];
    }

    /**
     * @dataProvider getPositions
     *
     * @param string $position
     */
    public function testPosition($position)
    {
        $this->assertSame($this->entity, $this->entity->setPosition($position));
        $this->assertSame($position, $this->entity->getPosition());
    }

    public function getDecoFunctions()
    {
        return [
            [
                'getTitle',
                'Foo',
            ],
            [
                'getFirstName',
                'Foo',
            ],
            [
                'getLastName',
                'Foo',
            ],
            [
                'getName',
                'Foo',
            ],
            [
                'getAddress',
                'Foo',
            ],
            [
                'getEmail',
                'Foo',
            ],
            [
                '__toString',
                'Foo',
            ],
        ];
    }

    /**
     * @dataProvider getDecoFunctions
     *
     * @param string $func
     * @param string $returnValue
     */
    public function testDecoratorFunctions($func, $returnValue)
    {
        $this->person->expects($this->once())->method($func)->will($this->returnValue($returnValue));
        $this->assertSame($returnValue, $this->entity->$func());
    }
}
