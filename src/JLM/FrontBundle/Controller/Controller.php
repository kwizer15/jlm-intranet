<?php

/*
 * This file is part of the JLMFrontBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\NoResultException;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Controller extends BaseController
{
    protected function getConnectedManager()
    {
        $service = (Kernel::MINOR_VERSION > 3) ? 'security.token_storage' : 'security.context';
        $securityTokenStorage = $this->container->get($service);

        if (false === $securityTokenStorage->isGranted('ROLE_MANAGER')
            && false === $securityTokenStorage->isGranted(
                'ROLE_BUSINESS'
            )) {
            throw new AccessDeniedException();
        }

        $om = $this->get('doctrine')->getManager();
        $repoManager = $securityTokenStorage->isGranted('ROLE_MANAGER') ? $om->getRepository('JLMModelBundle:Trustee')
            : $om->getRepository('JLMModelBundle:Site');

        try {
            $manager = $repoManager->getByUser($securityTokenStorage->getToken()->getUser());
        } catch (NoResultException $e) {
            if (false === $securityTokenStorage->isGranted('ROLE_ADMIN')) {
                throw new AccessDeniedException('Pas de contact lié à ce compte');
            }
            $session = $this->getRequest()->getSession();
            if ($managerId = $this->getRequest()->get('managerId')) {
                $session->set('managerId', $managerId);
            }
            $manager = $repoManager->find($session->get('managerId', 316)); // Pour tests
        }

        return $manager;
    }
}
