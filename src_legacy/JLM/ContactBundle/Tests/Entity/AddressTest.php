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

use JLM\ContactBundle\Entity\Address;
use JLM\ContactBundle\Model\CityInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AddressTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Address
     */
    protected $entity;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new Address();
    }

    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ContactBundle\Model\AddressInterface', $this->entity);
        $this->assertNull($this->entity->getId());
        $this->assertSame('', $this->entity->getStreet());
        $this->assertNull($this->entity->getCity());
        $this->assertSame('', $this->entity->__toString());
    }

    public function getStreets()
    {
        return [
            [
                '1, rue Bidule Machin Truc',
                '1, rue Bidule Machin Truc',
            ],
            [
                153,
                '153',
            ],
        ];
    }

    /**
     * @dataProvider getStreets
     */
    public function testStreet($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setStreet($in));
        $this->assertSame($out, $this->entity->getStreet());
    }

    public function getCities()
    {
        return [
            [$this->createMock(CityInterface::class)],
        ];
    }

    /**
     * @dataProvider getCities
     */
    public function testCity($city)
    {
        $this->assertSame($this->entity, $this->entity->setCity($city));
        $this->assertSame($city, $this->entity->getCity());
    }

    public function getToStrings()
    {

        return [
            [
                '17 avenue de Montboulon',
                '77165',
                'Saint-Soupplets',
                '17 avenue de Montboulon' . chr(10) . '77165 - Saint-Soupplets',
            ],

        ];
    }

    /**
     * @dataProvider getToStrings
     */
    public function testToString($street, $zip, $cityname, $out)
    {
        $city = $this->createMock(CityInterface::class);
        $city->expects($this->once())->method('__toString')->will($this->returnValue($zip . ' - ' . $cityname));

        $this->entity->setStreet($street);
        $this->entity->setCity($city);
        $this->assertSame($out, $this->entity->__toString());
    }
}
