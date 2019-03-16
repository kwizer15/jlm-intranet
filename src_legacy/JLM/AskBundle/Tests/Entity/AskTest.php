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

use JLM\AskBundle\Entity\Ask;
use JLM\AskBundle\Model\AskInterface;
use JLM\AskBundle\Model\CommunicationMeansInterface;
use JLM\AskBundle\Model\ContactInterface;
use JLM\AskBundle\Model\PayerInterface;
use JLM\AskBundle\Model\SubjectInterface;
use JLM\ContactBundle\Entity\Person;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\Trustee;

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
        $this->entity = $this->getMockForAbstractClass(Ask::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf(AskInterface::class, $this->entity);
    }

    public function getGetterSetter()
    {
        return [
            ['Creation', new \DateTime(),],
            ['Maturity', new \DateTime(),],
            ['Ask', 'Foo',],
            ['DontTreat', 'Foo',],
            ['Contact', $this->createMock(ContactInterface::class),],
            ['Payer', $this->createMock(PayerInterface::class),],
            ['Method', $this->createMock(CommunicationMeansInterface::class),],
            ['Subject', $this->createMock(SubjectInterface::class),],
            // Deprecateds
            ['Person', $this->createMock(Person::class),],
            ['Trustee', $this->createMock(Trustee::class),],
            ['Site', $this->createMock(Site::class),],
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

    public function testIsCreationBeforeMaturity()
    {
        $this->entity->setCreation(new \DateTime());
        $this->entity->setMaturity(new \DateTime());
        $this->assertTrue($this->entity->isCreationBeforeMaturity());
    }
}
