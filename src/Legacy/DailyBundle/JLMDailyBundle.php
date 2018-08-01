<?php

namespace JLM\DailyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use JLM\DailyBundle\DependencyInjection\Compiler\FormPass;

class JLMDailyBundle extends Bundle
{
	/**
	 * {@inheritdoc}
	 */
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		$container->addCompilerPass(new FormPass());
	}
}
