<?php

/*
 * This file is part of the JLMFrontBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FrontBundle\Mailer;

use JLM\FrontBundle\Model\ContactInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class TwigSwiftMailer implements MailerInterface
{
    protected $mailer;
    protected $router;
    protected $twig;
    protected $parameters;

    public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $router, \Twig_Environment $twig, array $parameters)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->twig = $twig;
        $this->parameters = $parameters;
    }

    /**
     *
     * @param ContactInterface $contact
     */
    public function sendContactEmailMessage(ContactInterface $contact)
    {
        $template = $this->parameters['template']['contact'];
        $context = [
            'contact' => $contact
        ];

        $this->sendMessage($template, $context, $contact->getEmail(), $this->parameters['from_email']['contact']);
    }
    
    /**
     *
     * @param ContactInterface $contact
     */
    public function sendConfirmContactEmailMessage(ContactInterface $contact)
    {
        $template = $this->parameters['template']['contact_confirm'];
        $context = [
                'contact' => $contact
        ];
    
        $this->sendMessage($template, $context, $this->parameters['from_email']['contact'], $contact->getEmail());
    }
    
    /**
     *
     * @param ContactInterface $contact
     */
    public function sendAskQuoteEmailMessage(ContactInterface $contact)
    {
        $template = $this->parameters['template']['askquote'];
        $context = [
                'contact' => $contact
        ];
    
        $this->sendMessage($template, $context, $contact->getEmail(), $this->parameters['from_email']['askquote']);
    }
    
    /**
     *
     * @param ContactInterface $contact
     */
    public function sendConfirmAskQuoteEmailMessage(ContactInterface $contact)
    {
        $template = $this->parameters['template']['askquote_confirm'];
        $context = [
                'contact' => $contact
        ];
    
        $this->sendMessage($template, $context, $this->parameters['from_email']['askquote'], $contact->getEmail());
    }

    /**
     * @param string $templateName
     * @param array  $context
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendMessage($templateName, $context, $fromEmail, $toEmail)
    {
        $template = $this->twig->loadTemplate($templateName);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail);

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        $this->mailer->send($message);
    }
}
