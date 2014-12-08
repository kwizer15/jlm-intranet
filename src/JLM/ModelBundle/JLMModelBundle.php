<?php

namespace JLM\ModelBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use JLM\ModelBundle\DependencyInjection\Compiler\FormPass;

class JLMModelBundle extends Bundle
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
