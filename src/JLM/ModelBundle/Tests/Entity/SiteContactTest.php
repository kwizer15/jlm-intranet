<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Tests\Entity;

use JLM\ModelBundle\Entity\SiteContact;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SiteContactTest extends \PHPUnit_Framework_TestCase
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
        $this->entity = new SiteContact;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
         
    }
    
    public function testPerson()
    {
        $person = $this->getMock('JLM\ContactBundle\Model\PersonInterface');
        $this->assertSame($this->entity, $this->entity->setPerson($person));
        $this->assertSame($person, $this->entity->getPerson());
    }
}