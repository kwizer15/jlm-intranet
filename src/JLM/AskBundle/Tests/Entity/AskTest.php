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
class AskTest extends \PHPUnit\Framework\TestCase
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
            array('DontTreat', 'Foo'),
        	array('Contact', $this->createMock('JLM\AskBundle\Model\ContactInterface')),
            array('Payer', $this->createMock('JLM\AskBundle\Model\PayerInterface')),
            array('Method', $this->createMock('JLM\AskBundle\Model\CommunicationMeansInterface')),
            array('Subject', $this->createMock('JLM\AskBundle\Model\SubjectInterface')),
            // Deprecateds
            array('Person', $this->createMock('JLM\ContactBundle\Entity\Person')),
            array('Trustee', $this->createMock('JLM\ModelBundle\Entity\Trustee')),
            array('Site', $this->createMock('JLM\ModelBundle\Entity\Site')),
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
    
    public function testIsCreationBeforeMaturity()
    {
        $this->entity->setCreation(new \DateTime);
        $this->entity->setMaturity(new \DateTime);
        $this->assertTrue($this->entity->isCreationBeforeMaturity());
    }
}