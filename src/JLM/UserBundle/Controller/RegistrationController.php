<?php
namespace JLM\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class RegistrationController extends BaseController
{
	public function registerAction(Request $request)
	{
		if (false === $this->container->get('security.authorization_checker')->isGranted('ROLE_OFFICE'))
		{
			throw new AccessDeniedException();
		}

		return parent::registerAction($request);
	}
}
