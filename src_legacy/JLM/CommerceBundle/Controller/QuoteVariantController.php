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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Mail;
use JLM\ModelBundle\Form\Type\MailType;
use JLM\CommerceBundle\Entity\QuoteVariant;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Event\QuoteVariantEvent;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\CommerceBundle\Builder\Email\QuoteVariantConfirmGivenMailBuilder;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;
use Symfony\Component\HttpFoundation\Request;

/**
 * QuoteVariant controller.
 *
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteVariantController extends Controller
{

    /**
     * Displays a form to create a new Variant entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $manager = $this->container->get('jlm_commerce.quotevariant_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $form = $manager->createForm('new', $request);
        if ($manager->getHandler($form)->process()) {
            return $manager->redirect('quote_show', ['id' => $form->get('quote')->getData()->getId()]);
        }

        return $manager->renderResponse(
            '@JLMCommerce/quote_variant/new.html.twig',
            [
                'quote' => $form->get('quote')->getData(),
                'entity' => $form->getData(),
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing QuoteVariant entity.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $manager = $this->container->get('jlm_commerce.quotevariant_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $manager->assertState($entity, [QuoteVariant::STATE_INSEIZURE]);
        $form = $manager->createForm('edit', $request, ['entity' => $entity]);
        if ($manager->getHandler($form)->process()) {
            return $manager->redirect('quote_show', ['id' => $entity->getQuote()->getId()]);
        }

        return $manager->renderResponse(
            '@JLMCommerce/quote_variant/edit.html.twig',
            [
                'quote' => $form->get('quote')->getData(),
                'entity' => $entity,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Change entity state and return the redirect show quote response
     * Can send a QuoteVariantEvent if the event name is defined
     *
     * @param Request $request
     * @param int $id
     * @param int $state
     * @param string $event
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function changeState(Request $request, $id, $state, $event = null)
    {
        $manager = $this->container->get('jlm_commerce.quotevariant_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        if ($entity->setState($state)) {
            if ($event !== null) {
                $manager->dispatch($event, new QuoteVariantEvent($entity, $request));
            }
            $em = $manager->getObjectManager();
            $em->persist($entity);
            $em->flush();
        }

        return $manager->redirect('quote_show', ['id' => $entity->getQuote()->getId()]);
    }

    /**
     * Note QuoteVariant as ready to send.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function readyAction(Request $request, $id)
    {
        return $this->changeState($request, $id, QuoteVariant::STATE_READY, JLMCommerceEvents::QUOTEVARIANT_READY);
    }

    /**
     * Note QuoteVariant as not ready.
     */
    public function unvalidAction(Request $request, $id)
    {
        return $this->changeState($request, $id, QuoteVariant::STATE_INSEIZURE, JLMCommerceEvents::QUOTEVARIANT_INSEIZURE);
    }

    /**
     * Note QuoteVariant as faxed.
     */
    public function faxAction(Request $request, $id)
    {
        return $this->changeState($request, $id, QuoteVariant::STATE_SENDED, JLMCommerceEvents::QUOTEVARIANT_SENDED);
    }

    /**
     * Note QuoteVariant as canceled.
     */
    public function cancelAction(Request $request, $id)
    {
        return $this->changeState($request, $id, QuoteVariant::STATE_CANCELED, JLMCommerceEvents::QUOTEVARIANT_CANCELED);
    }

    /**
     * Note QuoteVariant as receipt.
     */
    public function receiptAction(Request $request, $id)
    {
        return $this->changeState($request, $id, QuoteVariant::STATE_RECEIPT, JLMCommerceEvents::QUOTEVARIANT_RECEIPT);
    }

    /**
     * Accord du devis / Création de l'intervention
     *
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function givenAction(Request $request, $id)
    {
        $this->changeState($request, $id, QuoteVariant::STATE_GIVEN, JLMCommerceEvents::QUOTEVARIANT_GIVEN);
        $manager = $this->container->get('jlm_commerce.quotevariant_manager');

        return $manager->redirect('variant_email', ['id' => $id]);
    }

    /**
     * Email de confirmation d'accord de devis
     */
    public function emailAction(Request $request, $id)
    {
        // @todo Passer par un service de formPopulate et créer un controller unique dans CoreBundle
        $manager = $this->container->get('jlm_commerce.quotevariant_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $mail = MailFactory::create(new QuoteVariantConfirmGivenMailBuilder($entity));
        $editForm = $this->createForm(\JLM\CoreBundle\Form\Type\MailType::class, $mail);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $this->get('mailer')->send(MailFactory::create(new MailSwiftMailBuilder($editForm->getData())));

            return $this->redirect($this->generateUrl('quote_show', ['id' => $entity->getQuote()->getId()]));
        }

        return $manager->renderResponse(
            '@JLMCommerce/quote_variant/email.html.twig',
            [
                'entity' => $entity,
                'form' => $editForm->createView(),
            ]
        );
    }

    /**
     * Mail
     * @Template()
     */
    public function mailAction($id)
    {
        $manager = $this->container->get('jlm_commerce.quotevariant_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $manager->assertState(
            $entity,
            [
                QuoteVariant::STATE_READY,
                QuoteVariant::STATE_PRINTED,
                QuoteVariant::STATE_SENDED,
                QuoteVariant::STATE_RECEIPT,
                QuoteVariant::STATE_GIVEN,
            ]
        );
        $mail = new Mail();
        $mail->setSubject('Devis n°' . $entity->getNumber());
        $mail->setFrom('commerce@jlm-entreprise.fr');
        $mail->setBody(
            $this->renderView(
                '@JLMCommerce/quote_variant/email.txt.twig',
                ['intro' => $entity->getIntro(), 'door' => $entity->getQuote()->getDoorCp()]
            )
        );
        $mail->setSignature(
            $this->renderView(
                '@JLMCommerce/quote_variant/emailsignature.txt.twig',
                ['name' => $entity->getQuote()->getFollowerCp()]
            )
        );
        if ($entity->getQuote()->getContact()) {
            if ($entity->getQuote()->getContact()->getPerson()) {
                if ($entity->getQuote()->getContact()->getPerson()->getEmail()) {
                    $mail->setTo($entity->getQuote()->getContact()->getPerson()->getEmail());
                }
            }
        }
        $form = $this->createForm(MailType::class, $mail);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Send by mail a QuoteVariant entity.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendmailAction(Request $request, $id)
    {
        $manager = $this->container->get('jlm_commerce.quotevariant_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        if ($entity->getState() < QuoteVariant::STATE_READY) {
            return $manager->redirect('quote_show', ['id' => $entity->getQuote()->getId()]);
        }

        // Message
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $mail->setBcc('commerce@jlm-entreprise.fr');

            $message = $mail->getSwift();
            $message->setReadReceiptTo('commerce@jlm-entreprise.fr');
            $message->attach(
                \Swift_Attachment::newInstance(
                    $this->render('@JLMCommerce/quote/quote.pdf.php', ['entities' => [$entity]]),
                    $entity->getNumber() . '.pdf',
                    'application/pdf'
                )
            );
            $em = $this->getDoctrine()->getManager();
            if ($entity->getQuote()->getVat() == $entity->getQuote()->getVatTransmitter()) {
                $message->attach(
                    \Swift_Attachment::fromPath(
                        $this->get('kernel')->getRootDir() . '/../web/bundles/jlmcommerce/pdf/attestation.pdf'
                    )
                );
            }
            $this->get('mailer')->send($message);
            $entity->setState(QuoteVariant::STATE_SENDED);
            $manager->dispatch(JLMCommerceEvents::QUOTEVARIANT_SENDED, new QuoteVariantEvent($entity, $request));
            $em->persist($entity);
            $em->flush();
        }

        return $manager->redirect('quote_show', ['id' => $entity->getQuote()->getId()]);
    }

    /**
     * Print a Quote
     */
    public function printAction($id)
    {
        $manager = $this->container->get('jlm_commerce.quotevariant_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);

        return $manager->renderPdf(
            $entity->getNumber(),
            '@JLMCommerce/quote/quote.pdf.php',
            ['entities' => [$entity]]
        );
    }

    /**
     * Print a coding
     */
    public function printcodingAction($id)
    {
        $manager = $this->container->get('jlm_commerce.quotevariant_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        if ($entity->getState() == QuoteVariant::STATE_CANCELED) {
            return $manager->redirect('quote_show', ['id' => $entity->getQuote()->getId()]);
        }

        return $manager->renderPdf(
            'chiffrage-' . $entity->getNumber(),
            '@JLMCommerce/quote_variant/coding.pdf.php',
            ['entity' => $entity]
        );
    }

    public function boostAction()
    {
        $manager = $this->container->get('jlm_commerce.quotevariant_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $quotes = $manager->getRepository()->getToBoost();
        usort(
            $quotes,
            function ($a, $b) {
                if ($a->getTotalPrice() > $b->getTotalPrice()) {
                    return -1;
                } elseif ($a->getTotalPrice() == $b->getTotalPrice()) {
                    return 0;
                } else {
                    return 1;
                }
            }
        );

        return $manager->renderResponse('@JLMCommerce/quote_variant/boost.html.twig', ['quotes' => $quotes]);
    }
}
