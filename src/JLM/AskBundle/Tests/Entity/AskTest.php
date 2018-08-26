<?php

/*
 * This file is part of the JLMAskBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\AskBundle\Tests\Entity;

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
        return [
            ['Creation', new \DateTime],
            ['Maturity', new \DateTime],
            ['Ask', 'Foo'],
            ['DontTreat', 'Foo'],
            ['Contact', $this->getMock('JLM\AskBundle\Model\ContactInterface')],
            ['Payer', $this->getMock('JLM\AskBundle\Model\PayerInterface')],
            ['Method', $this->getMock('JLM\AskBundle\Model\CommunicationMeansInterface')],
            ['Subject', $this->getMock('JLM\AskBundle\Model\SubjectInterface')],
            // Deprecateds
            ['Person', $this->getMock('JLM\ContactBundle\Entity\Person')],
            ['Trustee', $this->getMock('JLM\ModelBundle\Entity\Trustee')],
            ['Site', $this->getMock('JLM\ModelBundle\Entity\Site')],
        ];
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
    
    public function testIsCreationBeforeMaturity()
    {
        $this->entity->setCreation(new \DateTime);
        $this->entity->setMaturity(new \DateTime);
        $this->assertTrue($this->entity->isCreationBeforeMaturity());
    }
}
