<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\UserBundle\Tests\Entity;

use JLM\UserBundle\Entity\User;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class UserTest extends \PHPUnit\Framework\TestCase
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
        $this->entity = new User;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('FOS\UserBundle\Model\User', $this->entity); 
    }
    
    public function testGetPerson()
    {
        $person = $this->createMock('JLM\ContactBundle\Model\ContactInterface');
        $this->assertSame($this->entity, $this->entity->setContact($person));
        $this->assertSame($person, $this->entity->getContact());
    }
}