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

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Person controller.
 */
class CorporationContactController extends ContainerAware
{
	/**
	 * Edit or add a contact
	 * @param int|string $id The entity identifier
	 * @return Response
	 */
	public function editAction($id = 0)
	{
		$manager = $this->container->get('jlm_contact.corporationcontact_manager');
		$router = $manager->getRouter();	
		$entity = $manager->getEntity($id);
		$formName = ($id) ? 'edit' : 'new';
		$form = $manager->createForm($formName, array('entity' => $entity));
		$ajax = $manager->getRequest()->isXmlHttpRequest();
		if ($manager->getHandler($form, $entity)->process())
		{
			if ($ajax)
			{
				$contact = $manager->getRepository()->getByIdToArray($entity->getId());
				$contact['contact']['contact']['show_link'] =  $router->generate('jlm_contact_contact_show', array('id' => $contact['contact']['id']));
				$contact['edit_link'] = $manager->getEditUrl($contact['id']);
				$contact['delete_link'] = $manager->getDeleteUrl($contact['id']);

				$response = new JsonResponse($contact);
			}
			else
			{
				$response = $manager->redirect('jlm_contact_contact_show', array('id' => $entity->getCorporation()->getId()));
			}
		}
		else
		{
			$template = ($ajax) ? 'modal_new.html.twig'	: 'new.html.twig';
			$response = $manager->renderResponse('JLMContactBundle:CorporationContact:' . $template, array('form'=>$form->createView()));
		}
		
		return $response;
	}
	
	/**
	 * Remove a CorporationContact
	 * 
	 */
	public function deleteAction($id)
	{
		$manager = $this->container->get('jlm_contact.corporationcontact_manager');
		$entity = $manager->getEntity($id);
		$corpoId = $entity->getCorporation()->getId();
		$form = $manager->createDeleteForm($entity);
		$process = $manager->getHandler($form, $entity)->process('DELETE');
		if ($process)
		{
//			$manager->getSession()->setFlash('notice', $entity->getName().' a bien été supprimé');
			return new JsonResponse(array('delete'=>true));
//			return $manager->redirect('jlm_contact_contact_show', array('id' => $corpoId));
		}
		$ajax = $manager->getRequest()->isXmlHttpRequest();
		$template = ($ajax) ? 'modal_delete.html.twig'	: 'delete.html.twig';
		
		return $manager->renderResponse('JLMContactBundle:CorporationContact:' . $template, array('form'=>$form->createView()));
	}
}