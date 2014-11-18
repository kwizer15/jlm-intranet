<?php

/*
 * This file is part of the JLMFeeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FeeBundle\Tests\Entity;

use JLM\FeeBundle\Entity\FeesFollower;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FeesFollowerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Fee
     */
    protected $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new FeesFollower();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\FeeBundle\Model\FeesFollowerInterface', $this->entity);
        $this->assertNull($this->entity->getId());
    }
    
    public function getGetterSetter()
    {
        return array(
            array('Activation', new \DateTime()),
            array('Generation', new \DateTime()),
            array('Frequence1', 0.2),
        	array('Frequence2', 0.2),
        	array('Frequence4', 0.2),
        );
    }
    
    /**
     * @dataProvider getGetterSetter
     */
    public function testGetterSetter($attribute, $value)
    {
        $getter = 'get'.$attribute;
        $setter = 'set'.$attribute;
        $this->assertSame($this->entity, $this->entity->$setter($value));
        $this->assertSame($value, $this->entity->$getter());
    }
    
    public function getFrequences()
    {
        return array(
        	array(1),
            array(2),
            array(4),
        );
    }
    
    /**
     * @dataProvider getFrequences
     */
    public function testGetFrequence($freq)
    {
    	$setter = 'setFrequence' . $freq;
        $this->entity->$setter(0.2);
        $this->assertSame(0.2, $this->entity->getFrequence($freq));
    }
    
    public function testIsNotActive()
    {
    	$date = new \DateTime();
    	$date->add(new \DateInterval('P1D'));
    	$this->entity->setActivation($date);
    	$this->assertFalse($this->entity->isActive());
    }
    
    public function testIsActive()
    {
    	$date = new \DateTime();
    	$date->sub(new \DateInterval('P1D'));
    	$this->entity->setActivation($date);
    	$this->assertTrue($this->entity->isActive());
    }
}