<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Tests\Entity;


/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AskTest extends \PHPUnit_Framework_TestCase
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
        $this->entity = $this->getMockForAbstractClass('JLM\AskBundle\Entity\Ask');
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\AskBundle\Model\AskInterface', $this->entity);
    }
    
    public function getGetterSetter()
    {
        return array(
            array('Creation', new \DateTime),
            array('Maturity', new \DateTime),
            array('Ask', 'Foo'),
        	array('Contact', $this->getMock('JLM\AskBundle\Model\ContactInterface')),
            array('Payer', $this->getMock('JLM\AskBundle\Model\PayerInterface')),
            array('Method', $this->getMock('JLM\AskBundle\Model\CommunicationMeansInterface')),
            array('Subject', $this->getMock('JLM\AskBundle\Model\SubjectInterface')),
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
}