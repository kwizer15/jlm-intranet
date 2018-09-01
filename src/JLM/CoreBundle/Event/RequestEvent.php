<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class RequestEvent extends Event
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Constructor
     *
     * @param Request       $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get request parameter
     *
     * @return string
     */
    public function getParam($param, $default = null, $deep = false)
    {
        return $this->request->get($param, $default, $deep);
    }
}
