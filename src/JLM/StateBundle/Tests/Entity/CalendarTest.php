<?php

/*
 * This file is part of the JLMStateBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\StateBundle\Tests\Entity;

use JLM\StateBundle\Entity\Calendar;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class StateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Country
     */
    protected $entity;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new Calendar();
    }

    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        //        $this->assertInstanceOf('JLM\AskBundle\Model\AskInterface', $this->entity);
    }

    public function getGetterSetter()
    {
        return [
            [
                'Dt',
                new \DateTime(),
            ],
            [
                'Date',
                new \DateTime(),
            ],
        ];
    }

    /**
     * @dataProvider getGetterSetter
     */
    public function testGetterSetter($attribute, $value)
    {
        $getter = 'get' . $attribute;
        $setter = 'set' . $attribute;
        $this->assertSame($this->entity, $this->entity->$setter($value));
        $this->assertSame($value, $this->entity->$getter());
    }
}
