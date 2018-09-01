<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Tests\Entity;

use JLM\ContractBundle\Entity\Contract;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContractTest extends \PHPUnit\Framework\TestCase
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
        $this->entity = new Contract();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
         $this->assertInstanceOf('JLM\ContractBundle\Model\ContractInterface', $this->entity);
         $this->assertNull($this->entity->getId());
    }
    
    public function testNumber()
    {
        $this->assertSame($this->entity, $this->entity->setNumber('123'));
        $this->assertSame('123', $this->entity->getNumber());
    }
    
    public function testTrustee()
    {
        $trustee = $this->createMock('JLM\ModelBundle\Entity\Trustee');
        $this->assertSame($this->entity, $this->entity->setTrustee($trustee));
        $this->assertSame($trustee, $this->entity->getTrustee());
    }
    
    public function testComplete()
    {
        $this->assertSame($this->entity, $this->entity->setComplete(true));
        $this->assertSame(true, $this->entity->getComplete());
        $this->assertSame(true, $this->entity->isComplete());
        $this->assertSame(false, $this->entity->getNormal());
        $this->assertSame(false, $this->entity->isNormal());
    }
    
    public function testNormal()
    {
        $this->assertSame($this->entity, $this->entity->setNormal(true));
        $this->assertSame(true, $this->entity->getNormal());
        $this->assertSame(true, $this->entity->isNormal());
        $this->assertSame(false, $this->entity->getComplete());
        $this->assertSame(false, $this->entity->isComplete());
    }
    
    public function testOption()
    {
        $this->assertSame($this->entity, $this->entity->setOption(true));
        $this->assertSame(true, $this->entity->getOption());
    }
    
    public function testDoor()
    {
        $door = $this->createMock('JLM\ModelBundle\Entity\Door');
        $this->assertSame($this->entity, $this->entity->setDoor($door));
        $this->assertSame($door, $this->entity->getDoor());
    }
    
    public function testBegin()
    {
        $date = $this->createMock('DateTime');
        $this->assertSame($this->entity, $this->entity->setBegin($date));
        $this->assertSame($date, $this->entity->getBegin());
    }
    
    public function testEndWarranty()
    {
        $date = $this->createMock('DateTime');
        $this->assertSame($this->entity, $this->entity->setEndWarranty($date));
        $this->assertSame($date, $this->entity->getEndWarranty());
    }
    
    public function testEnd()
    {
        $date = $this->createMock('DateTime');
        $this->assertSame($this->entity, $this->entity->setEnd($date));
        $this->assertSame($date, $this->entity->getEnd());
    }
    
    public function testFee()
    {
        $fee = 123.45;
        $this->assertSame($this->entity, $this->entity->setFee($fee));
        $this->assertSame($fee, $this->entity->getFee());
    }
    
    public function getOptions()
    {
        return [
                [
                 true,
                 false,
                 'C1',
                ],
                [
                 true,
                 true,
                 'C2',
                ],
                [
                 false,
                 false,
                 'N3',
                ],
                [
                 false,
                 true,
                 'N4',
                ],
               ];
    }
    
    /**
     * @dataProvider getOptions
     */
    public function testToString($complete, $option, $out)
    {
        $this->entity->setComplete($complete);
        $this->entity->setOption($option);
        $this->assertSame($out, $this->entity->__toString());
    }
    
    public function testInProgress()
    {
        $this->entity->setBegin(new \DateTime);
        $this->assertTrue($this->entity->getInProgress());
        $this->entity->setEnd(new \DateTime);
        $this->assertFalse($this->entity->getInProgress());
    }
}
