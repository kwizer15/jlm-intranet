<?php
namespace JLM\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RegistrationController extends BaseController
{
	public function registerAction()
	{
		$service = (Kernel::MAJOR_VERSION == 2 && Kernel::MINOR_VERSION > 3) ? 'security.token_storage' : 'security.context';
		if (false === $this->container->get($service)->isGranted('ROLE_OFFICE'))
		{
			throw new AccessDeniedException();
		}
		
		return parent::registerAction();
	}
}