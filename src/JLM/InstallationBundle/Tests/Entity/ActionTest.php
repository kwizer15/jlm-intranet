<?php

/*
 * This file is part of the intervention-bundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\InstallationBundle\Tests\Entity;

use JLM\InstallationBundle\Entity\Action;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ActionTest extends \PHPUnit_Framework_TestCase
{
    private $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new Action('foo');
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\InstallationBundle\Model\ActionInterface', $this->entity);
    }
    
    public function testGetName()
    {
        $this->assertSame('foo', $this->entity->getName());
    }
}