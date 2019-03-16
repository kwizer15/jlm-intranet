<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JLM\ContractBundle\Event\ContractEvent;
use JLM\ContractBundle\JLMContractEvents;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContractController extends Controller
{
    /**
     * Lists all Contract entities.
     *
     * @deprecated not used
     */
    public function indexAction()
    {
        $manager = $this->container->get('jlm_contract.contract_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entities = $manager->getRepository()->findAll();

        return $manager->renderResponse('@JLMContract/contract/index.html.twig', ['entities' => $entities]);
    }

    /**
     * Finds and displays a Contract entity.
     */
    public function showAction($id)
    {
        $manager = $this->container->get('jlm_contract.contract_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);

        return $manager->renderResponse('@JLMContract/contract/show.html.twig', ['entity' => $entity]);
    }

    /**
     * Creates a new Contract entity.
     */
    public function newAction(Request $request)
    {
        $manager = $this->container->get('jlm_contract.contract_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $form = $manager->createForm('new', $request);
        $ajax = $request->isXmlHttpRequest();
        if ($manager->getHandler($form)->process('POST')) {
            $event = new ContractEvent($form->getData());
            $manager->dispatch(JLMContractEvents::AFTER_CONTRACT_CREATE, $event);

            return $ajax
                ? $manager->renderJson()
                : $manager->redirect('door_show', ['id' => $form->getData()->getDoor()->getId()]);
        }

        $template = $ajax
            ? '@JLMContract/contract/modal_new.html.twig'
            : '@JLMContract/contract/new.html.twig';

        return $manager->renderResponse(
            $template,
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Edits an existing Contract entity.
     */
    public function editAction(Request $request, $id, $formName)
    {
        $manager = $this->container->get('jlm_contract.contract_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $ajax = $request->isXmlHttpRequest();
        $form = $manager->createForm($formName, $request, ['entity' => $entity]);
        if ($manager->getHandler($form)->process()) {
            $event = new ContractEvent($form->getData());
            //          $manager->dispatch(JLMContractEvents::AFTER_CONTRACT_PERSIST, $event);

            return $ajax ? $manager->renderJson([])
                : $manager->redirect($this->generateUrl('door_show', ['id' => $entity->getDoor()->getId()]));
        }
        $template = $ajax ? '@JLMContract/contract/modal_edit.html.twig'
            : '@JLMContract/contract/edit.html.twig';

        return $manager->renderResponse(
            $template,
            [
                'form' => $form->createView(),
            ]
        );
    }
}
