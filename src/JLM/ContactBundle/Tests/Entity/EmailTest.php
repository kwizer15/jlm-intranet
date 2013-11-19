<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Email;
use JLM\ContactBundle\Entity\EmailException;

class EmailTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testEmail()
	{
		$tests = array(
			array('salut'),
			array('kwiZer15@WANADOO.fr','kwizer15@wanadoo.fr'),
			array('emmanuel.bernaszuk@kw12er.com','emmanuel.bernaszuk@kw12er.com'),
			array('  emmanuel.bernaszuk@kw12er.com   ','emmanuel.bernaszuk@kw12er.com'),
			array('emmanuel bernaszuk@kw12er.com'),
			array('émmanuel.bernaszuk@kw12er.com'),
			array('kwizer15@hotmail;com'),
			array('kwizer 15@hotmail.com'),
					
		);
		
		foreach ($tests as $test)
		{
			try {
				$entity = new Email($test[0]);
			} catch (EmailException $e) {
				if (isset($test[1]))
					$this->fail('Une exception non attendue a été levée : '.$test[0]);
				continue;
			}
			if (!isset($test[1]))
				$this->fail('Une exception attendue n\'a pas été levée : '.$test[0]);
			else
				$this->assertEquals($test[1],(string)$entity);
		}
	}
}