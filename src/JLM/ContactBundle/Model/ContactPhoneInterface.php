<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Model;

use JLM\ContactBundle\Model\ContactInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface ContactPhoneInterface extends PhoneInterface
{
	public function setContact(ContactInterface $contact = null);
}