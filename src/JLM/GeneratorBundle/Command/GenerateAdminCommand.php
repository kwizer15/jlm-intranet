<?php
namespace JLM\GeneratorBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;

class GenerateAdminCommand extends GenerateDoctrineCrudCommand
{
	protected function configure()
	{
		parent::configure();
		$this->setName('jlm:generate:crud');
		$this->setDescription('Admin generator');
	}
	protected function getGenerator()
	{
		if (null === $this->generator)
		{
			$this->generator = new DoctrineCrudGenerator($this->getContainer()->get('filesystem'), __DIR__.'/../Resources/skeleton/crud');
		}

		return $this->generator;
	}
}