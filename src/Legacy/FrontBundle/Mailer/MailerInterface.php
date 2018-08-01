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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface MailerInterface
{
    /**
     * Send a contact email to admin
     *
     * @param ContactInterface $contact
     *
     * @return void
     */
    public function sendContactEmailMessage(ContactInterface $contact);
    
    /**
     * Send a confirmation to contact
     *
     * @param ContactInterface $contact
     *
     * @return void
     */
    public function sendConfirmContactEmailMessage(ContactInterface $contact);
}
