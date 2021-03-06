<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Person controller.
 */
class CorporationContactController implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    /**
     * Edit or add a contact
     *
     * @param int|string $id The entity identifier
     *
     * @return Response
     */
    public function editAction(Request $request, $id = 0)
    {
        $manager = $this->container->get('jlm_contact.corporationcontact_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $router = $manager->getRouter();
        $entity = $manager->getEntity($id);
        $formName = ($id) ? 'edit' : 'new';
        $form = $manager->createForm($formName, $request, ['entity' => $entity]);
        $ajax = $request->isXmlHttpRequest();
        if ($manager->getHandler($form)->process()) {
            $entity = $form->getData();
            if ($ajax) {
                $contact = $manager->getRepository()->getByIdToArray($entity->getId());
                $contact['contact']['contact']['show_link'] = $router->generate(
                    'jlm_contact_contact_show',
                    ['id' => $contact['contact']['id']]
                );
                $contact['edit_link'] = $manager->getEditUrl($contact['id']);
                $contact['delete_link'] = $manager->getDeleteUrl($contact['id']);

                $response = new JsonResponse($contact);
            } else {
                $response = $manager->redirect(
                    'jlm_contact_contact_show',
                    ['id' => $entity->getCorporation()->getId()]
                );
            }
        } else {
            $template = $ajax ? 'modal_new.html.twig' : 'new.html.twig';
            $response = $manager->renderResponse(
                '@JLMContact/corporation_contact/' . $template,
                ['form' => $form->createView()]
            );
        }

        return $response;
    }

    /**
     * Remove a CorporationContact
     *
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse|Response
     */
    public function deleteAction(Request $request, $id)
    {
        $manager = $this->container->get('jlm_contact.corporationcontact_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $form = $manager->createForm('delete', $request, ['entity' => $entity]);
        $process = $manager->getHandler($form, $entity)->process('DELETE');
        if ($process) {
            //          $manager->getSession()->setFlash('notice', $entity->getName().' a bien été supprimé');

            return new JsonResponse(['delete' => true]);
        }
        $ajax = $request->isXmlHttpRequest();
        $template = $ajax ? 'modal_delete.html.twig' : 'delete.html.twig';

        return $manager->renderResponse(
            '@JLMContact/corporation_contact/' . $template,
            ['form' => $form->createView()]
        );
    }
}
