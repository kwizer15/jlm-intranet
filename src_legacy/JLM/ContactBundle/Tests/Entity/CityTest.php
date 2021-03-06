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

use JLM\ContactBundle\Entity\City;
use JLM\ContactBundle\Model\CountryInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CityTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var City
     */
    protected $entity;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new City();
    }

    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ContactBundle\Model\CityInterface', $this->entity);
        $this->assertNull($this->entity->getId());
        $this->assertSame('', $this->entity->getName());
        $this->assertSame('', $this->entity->getZip());
        $this->assertNull($this->entity->getCountry());
        $this->assertSame('', $this->entity->__toString());
    }

    /**
     * Get names
     *
     * @return array
     */
    public function getNames()
    {
        return [
            ['paris','Paris',],
            ['MONTPELLIER','Montpellier',],
            ['bouLOgNe-biLLancOuRt','Boulogne-Billancourt',],
            ['Paris 13 Buttes-Chaumonts','Paris 13 Buttes-Chaumonts',],
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
     * Get zips
     *
     * @return array
     */
    public function getZips()
    {
        return [
            ['77280','77280',],
            ['2B280','2B280',],
            ['2a280','2A280',],
            ['dCg-Pt3','DCG-PT3',],
            [52364,'52364',],
            ['?', '',],
        ];
    }

    /**
     * @dataProvider getZips
     */
    public function testZip($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setZip($in));
        $this->assertSame($out, $this->entity->getZip());
    }

    /**
     * Get countries
     *
     * @return array
     */
    public function getCountries()
    {
        return [
            [null],
            [$this->createMock(CountryInterface::class)],
        ];
    }

    /**
     * @dataProvider getCountries
     */
    public function testCountry($country)
    {
        $this->assertSame($this->entity, $this->entity->setCountry($country));
        $this->assertSame($country, $this->entity->getCountry());
    }

    /**
     * Get toStrings
     *
     * @return array
     */
    public function getToStrings()
    {
        return [
            [77280, 'othis', '77280 - Othis', ],
        ];
    }

    /**
     * @dataProvider getToStrings
     */
    public function testToString($zip, $name, $out)
    {
        $this->entity->setZip($zip)->setName($name);
        $this->assertEquals($out, $this->entity->__toString());
    }
}
