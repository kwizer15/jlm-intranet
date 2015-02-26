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

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormPopulatingEvent extends RequestEvent
{
	/**
	 * @var FormInterface
	 */
    private $form;

    /**
     * @param FormInterface $form
     * @param Request $request
     */
    public function __construct(FormInterface $form, Request $request)
    {
    	$this->form = $form;
    	parent::__construct($request);
    }
    
    public function getForm()
    {
    	return $this->form;
    }
    
    public function getFormParam($formName, $paramName)
    {
    	$id = $this->getParam($formName, array($paramName => $this->getParam($paramName)));
    
    	return (isset($id[$paramName]) && $id[$paramName] !== null) ? $id[$paramName] : null;
    }
}