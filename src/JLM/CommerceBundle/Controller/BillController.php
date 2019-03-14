<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Controller;

use JLM\CoreBundle\Form\Type\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAware;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use JLM\CoreBundle\Entity\Search;
use JLM\CommerceBundle\Builder\Email\BillBoostMailBuilder;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;
use JLM\CommerceBundle\Builder\Email\BillBoostBusinessMailBuilder;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use JLM\CommerceBundle\Excel\BillState;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillController extends Controller
{
    /**
     * List bills
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $manager = $this->container->get('jlm_commerce.bill_manager');

        return $manager->renderResponse(
            'JLMCommerceBundle:Bill:index.html.twig',
            $manager->paginator(
                'JLMCommerceBundle:Bill',
                $request,
                ['sort' => '!number', 'state' => null, 'year' => null]
            )
        );
    }

    /**
     * Finds and displays a Bill entity.
     */
    public function showAction($id)
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return $manager->renderResponse(
            'JLMCommerceBundle:Bill:show.html.twig',
            ['entity' => $manager->getEntity($id)]
        );
    }

    /**
     * Displays a form to create a new Bill entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $form = $manager->createForm('new', $request);
        if ($manager->getHandler($form)->process()) {
            $entity = $form->getData();
            $manager->dispatch(JLMCommerceEvents::BILL_AFTER_PERSIST, new BillEvent($entity, $request));

            return $manager->redirect('bill_show', ['id' => $form->getData()->getId()]);
        }

        return $manager->renderResponse(
            'JLMCommerceBundle:Bill:new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing Bill entity.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $manager->assertState($entity, [0]);
        $editForm = $manager->createForm('edit', $request, ['entity' => $entity]);

        if ($manager->getHandler($editForm, $entity)->process()) {
            return $manager->redirect('bill_show', ['id' => $entity->getId()]);
        }

        return $manager->renderResponse(
            'JLMCommerceBundle:Bill:edit.html.twig',
            [
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
            ]
        );
    }

    /**
     * Imprimer la facture
     */
    public function printAction($id)
    {
        return $this->printer($id);
    }

    /**
     * Imprimer un duplicata de facture
     */
    public function printduplicateAction($id)
    {
        return $this->printer($id, true);
    }

    private function printer($id, $duplicate = false)
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        // $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $filename = $entity->getNumber();
        if ($duplicate) {
            $filename .= '-duplicata';
        }
        $filename .= '.pdf';

        return $manager->renderPdf(
            $filename,
            'JLMCommerceBundle:Bill:print.pdf.php',
            ['entities' => [$entity], 'duplicate' => $duplicate]
        );
    }

    /**
     * Imprimer la liste des factures à faire
     */
    public function printlistAction()
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return $manager->renderPdf(
            'factures-a-faire',
            'JLMCommerceBundle:Bill:printlist.pdf.php',
            ['entities' => $manager->getObjectManager()->getRepository('JLMDailyBundle:Intervention')->getToBilled()]
        );
    }

    /**
     * Note Bill as ready to send.
     */
    public function readyAction($id)
    {
        return $this->stateChange($id, 1);
    }

    /**
     * Note Bill as been send.
     */
    public function sendAction($id)
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        if ($entity->getState() != 1) {
            $entity->setState(1);
        }
        $em = $manager->getObjectManager();
        $em->persist($entity);
        $em->flush();

        return $manager->redirectReferer();
    }

    /**
     * Note Bill as been canceled.
     */
    public function cancelAction($id)
    {
        return $this->stateChange($id, -1);
    }

    /**
     * Note Bill retour à la saisie.
     */
    public function backAction($id)
    {
        return $this->stateChange($id, 0);
    }

    /**
     * Note Bill réglée.
     */
    public function payedAction($id)
    {
        return $this->stateChange($id, 2);
    }

    private function stateChange($id, $newState)
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        switch ($newState) {
            case 1:
                $redirect = ($entity->getState() < 0);
                $set = ($entity->getState() < $newState);
                break;
            case 2:
                $redirect = ($entity->getState() > 1);
                $set = ($entity->getState() == 1);
                break;
            case -1:
            case 0:
                $redirect = ($entity->getState() < 1);
                $set = ($entity->getState() > $newState);
                break;
        }
        if ($redirect) {
            return $manager->redirect('bill_show', ['id' => $entity->getId()]);
        }
        if ($set) {
            $entity->setState($newState);
        }
        $em = $manager->getObjectManager();
        $em->persist($entity);
        $em->flush();

        return $manager->redirectReferer();
    }

    /**
     * Display bills to do
     */
    public function todoAction()
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $om = $manager->getObjectManager();
        $list = $om->getRepository('JLMDailyBundle:Intervention')->getToBilled();
        $forms_externalBill = [];
        foreach ($list as $interv) {
            $forms_externalBill[] = $manager->getFormFactory()->createNamed(
                'externalBill' . $interv->getId(),
                ExternalBillType::class,
                $interv
            )->createView()
            ;
        }
        return $manager->renderResponse(
            'JLMCommerceBundle:Bill:todo.html.twig',
            [
                'entities' => $list,
                'forms_externalbill' => $forms_externalBill,
            ]
        );
    }

    /**
     * Display bills to boost
     */
    public function toboostAction()
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return $manager->renderResponse(
            'JLMCommerceBundle:Bill:toboost.html.twig',
            ['entities' => $manager->getRepository()->getToBoost()]
        );
    }

    /**
     * Email de relance facture
     *
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function boostemailAction(Request $request, $id)
    {
        // @todo Passer par un service de formPopulate et créer un controller unique dans CoreBundle
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $site = $entity->getSiteObject();
        $builder = ($site === null) ? new BillBoostMailBuilder($entity) : new BillBoostBusinessMailBuilder($site);
        $mail = MailFactory::create($builder);
        $editForm = $this->container->get('form.factory')->create(MailType::class, $mail);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $this->container->get('mailer')->send(MailFactory::create(new MailSwiftMailBuilder($editForm->getData())));
            $this->container->get('event_dispatcher')->dispatch(
                JLMCommerceEvents::BILL_BOOST_SENDMAIL,
                new BillEvent($entity, $request)
            )
            ;

            return $manager->redirectReferer();
        }

        return $manager->renderResponse(
            'JLMCommerceBundle:Bill:boostemail.html.twig',
            [
                'entity' => $entity,
                'form' => $editForm->createView(),
            ]
        );
    }

    /**
     * Imprimer le courrier de relance
     */
    public function printboostAction($id)
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);

        return $manager->renderPdf(
            $entity->getNumber(),
            'JLMCommerceBundle:Bill:printboost.pdf.php',
            ['entities' => [$entity]]
        );
    }

    /**
     * Noter relance effectuée
     */
    public function boostokAction($id)
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $date = new \DateTime();
        if ($entity->getFirstBoost() === null) {
            $entity->setFirstBoost($date);
        } else {
            $entity->setSecondBoost($date);
        }
        $em = $manager->getObjectManager();
        $em->persist($entity);
        $em->flush();

        return $manager->redirect('bill_toboost');
    }

    /**
     * Search
     */
    public function searchAction(Request $request)
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $formData = $request->get('jlm_core_search');
        $params = [];
        if (is_array($formData) && array_key_exists('query', $formData)) {
            $params = ['results' => $manager->getRepository()->search($formData['query'])];
        }

        return $manager->renderResponse('JLMCommerceBundle:Bill:search.html.twig', $params);
    }

    public function updateAction()
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $om = $manager->getObjectManager();
        $bills = $manager->getRepository()->findAll();
        foreach ($bills as $bill) {
            $bill->getTotalPrice();
            $om->persist($bill);
        }
        $om->flush();

        return $manager->redirectReferer();
    }

    /**
     *
     * @param Request $request
     *
     * @return multitype:unknown
     */
    public function stateExcelAction(Request $request)
    {
        $manager = $this->container->get('jlm_commerce.bill_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $list = $manager->getRepository()->getStateBill($request->get('fee', 11));

        $excelBuilder = new BillState($this->container->get('phpexcel'));

        return $excelBuilder->createList($list)->getResponse();
    }
}
