<?php

namespace Kwizer\ModalBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Kwizer\ModalBundle\DependencyInjection\Compiler\FormPass;

class KwizerModalBundle extends Bundle
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
