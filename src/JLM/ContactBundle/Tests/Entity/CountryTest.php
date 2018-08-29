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

use JLM\ContactBundle\Entity\Country;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CountryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Country
     */
    protected $entity;

    protected function setUp()
    {
        $this->entity = new Country();
    }

    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ContactBundle\Model\CountryInterface', $this->entity);
        $this->assertNull($this->entity->getCode());
        $this->assertSame('', $this->entity->getName());
    }

    /**
     * Valid codes
     *
     * @return array
     */
    public function getValidCodes()
    {
        return [
            [
                ' france',
                'FR',
            ],
            [
                'bElGiQuE',
                'BE',
            ],
            [
                'LU',
                'LU',
            ],
            [
                'an?g4ds52',
                'AN',
            ],
        ];
    }

    /**
     * @dataProvider getValidCodes
     */
    public function testValidCode($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setCode($in));
        $this->assertSame($out, $this->entity->getCode());
    }

    /**
     * Unvalid codes
     *
     * @return array
     */
    public function getUnvalidCodes()
    {
        return [
            ['2  '],
            ['M'],
            ['n*ull'],
            ['    12er1qs   '],
            ['e2e'],
        ];
    }

    /**
     * @dataProvider getUnvalidCodes
     * @expectedException Exception
     */
    public function testUnvalidCode($in)
    {
        $this->entity->setCode($in);
    }

    /**
     * Names
     *
     * @return array
     */
    public function getNames()
    {
        return [
            [
                'france',
                'France',
            ],
            [
                'bElGiQuE',
                'Belgique',
            ],
            [
                'LU',
                'Lu',
            ],
            [
                '2',
                '',
            ],
            [
                'M',
                'M',
            ],
            [
                'n',
                'N',
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
