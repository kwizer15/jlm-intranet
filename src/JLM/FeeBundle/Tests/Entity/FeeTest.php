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
     * @var Fee
     */
    protected $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new Fee();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\FeeBundle\Model\FeeInterface', $this->entity);
        $this->assertNull($this->entity->getId());
    }
    
    public function getGetterSetter()
    {
        return array(
            array('Address', 'Foo'),
            array('Prelabel', 'Foo'),
            array('Frequence', 1),
            array('Vat', $this->getMock('JLM\CommerceBundle\Model\VATInterface')),
            array('Trustee', $this->getMock('JLM\ModelBundle\Entity\Trustee')),
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
    
    public function getFrequenceStrings()
    {
        return array(
        	array(1, 'annuelle'),
            array(2, 'semestrielle'),
            array(4, 'trimestrielle'),
        );
    }
    
    /**
     * @dataProvider getFrequenceStrings
     */
    public function testGetFrequenceString($freq, $string)
    {
        $this->entity->setFrequence($freq);
        $this->assertSame($string, $this->entity->getFrequenceString());
    }
    
    public function getAdderRemover()
    {
        return array(
            array('Contract', 'Contracts', $this->getMock('JLM\ContractBundle\Model\ContractInterface')),
        );
    }
    
    /**
     * @dataProvider getAdderRemover
     */
    public function testAdderRemover($attribute, $attributes, $value)
    {
        $getters = 'get'.$attributes;
        $adder = 'add'.$attribute;
        $remover = 'remove'.$attribute;
        $this->assertCount(0, $this->entity->$getters());
        $this->assertFalse($this->entity->$remover($value));
        $this->assertTrue($this->entity->$adder($value));
        $this->assertCount(1, $this->entity->$getters());
        $this->assertTrue($this->entity->$remover($value));
        $this->assertCount(0, $this->entity->$getters());
    }

    public function testGetContractNumbers()
    {
        $c1 = $this->getMock('JLM\ContractBundle\Model\ContractInterface');
        $c2 = $this->getMock('JLM\ContractBundle\Model\ContractInterface');
        $c1->expects($this->once())->method('getNumber')->will($this->returnValue('12345'));
        $c2->expects($this->once())->method('getNumber')->will($this->returnValue('6789'));
        $this->entity->addContract($c1);
        $this->entity->addContract($c2);
        $this->assertSame(array('12345','6789'), $this->entity->getContractNumbers());
    }
}