<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FeeBundle\Tests\Entity;

use JLM\FeeBundle\Entity\Fee;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FeeTest extends \PHPUnit_Framework_TestCase
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
        $this->entity = new Fee;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
//        $this->assertInstanceOf('JLM\FeeBundle\Model\FeeInterface', $this->entity);
        $this->assertNull($this->entity->getId());
    }
    
    public function testTrue()
    {
        $this->assertTrue(true);
    }

}