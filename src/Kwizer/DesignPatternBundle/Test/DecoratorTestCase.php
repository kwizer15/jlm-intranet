<?php
namespace Kwizer\DesignPatternBundle\Test;

abstract class DecoratorTestCase extends \PHPUnit_Framework_TestCase
{
	/**
	 * The Mock of common interface
	 * @var mixed
	 */
	protected $interface;
	
	/**
	 * The abstract class tested
	 * @var mixed
	 */
	protected $entity;
	
	/**
	 * Get the interface name
	 * 
	 * @return string
	 */
	abstract protected function getInterfaceName();

	/**
	 * Get the decorator name
	 * 
	 * @return string
	 */
	abstract protected function getDecoratorName();
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->interface = $this->getMock($this->getInterfaceName());
		$this->entity = $this->getMockForAbstractClass($this->getDecoratorName(),array($this->interface));
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertInstanceOf($this->getInterfaceName(), $this->entity);
	}
	
	/**
	 * Test a method of decorator
	 * 
	 * @param string $methodName
	 * @param mixed $value
	 */
	public function assertDecoratorMethod($methodName, $value)
	{
		$this->interface->expects($this->once())
					->method($methodName)
					->will($this->returnValue($value));
		$this->assertSame($value, $this->entity->$methodName());
	}
	
}