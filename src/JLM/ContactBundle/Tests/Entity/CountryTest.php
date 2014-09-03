<?php

/*
 * This file is part of the JLMContactBundle package.
*
* (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Country;

class CountryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Country
     */
    protected $entity;
    
    protected function setUp()
    {
        $this->entity = new Country;
    }
    
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ContactBundle\Model\CountryInterface', $this->entity);
        $this->assertNull($this->entity->getCode());
        $this->assertSame('', $this->entity->getName());
    }
    
    /**
     * Valid codes
     * @return array
     */
    public function getValidCodes()
    {
        return array(
			array(' france', 'FR'),
			array('bElGiQuE', 'BE'),
			array('LU', 'LU'),
			array('an?g4ds52', 'AN'),
		);
    }
    
	/**
	 * @dataProvider getValidCodes
	 */
	public function testValidCode($in, $out)
	{
		$this->assertSame($this->entity, $this->entity->setCode($in));
		$this->assertSame($out, $this->entity->getCode());
	}
	
	/**
	 * Unvalid codes
	 * @return array
	 */
	public function getUnvalidCodes()
	{
	    return array(
	        array('2  '),
	        array('M'),
	        array('n*ull'),
	        array('    12er1qs   '),
	        array('e2e'),
	    );
	}
	
	/**
	 * @dataProvider getUnvalidCodes
	 * @expectedException Exception
	 */
	public function testUnvalidCode($in)
	{
	    $this->entity->setCode($in);
	}

	/**
	 * Names
	 * @return array
	 */
	public function getNames()
	{
	    return array(
	        array('france', 'France'),
	        array('bElGiQuE', 'Belgique'),
	        array('LU', 'Lu'),
	        array('2', ''),
	        array('M', 'M'),
	        array('n', 'N'),
	    );
	}
	
	/**
	 * @dataProvider getNames
	 */
	public function testName($in, $out)
	{
		$this->assertSame($this->entity, $this->entity->setName($in));
		$this->assertSame($out, $this->entity->getName());
	}
}