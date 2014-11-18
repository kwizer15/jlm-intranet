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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ContactBundle\Manager\ContactManager;
use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Entity\Person;

/**
 * Person controller.
 */
class ContactController extends Controller
{
    /**
     * Display contact list
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        return array();
    }
}