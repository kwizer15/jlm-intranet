<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class BillEvent extends Event
{
	/**
	 * @var FormInterface
	 */
    private $form;
    
    /**
     * @var Request
     */
    private $request;

    /**
     * @param FormInterface $form
     * @param Request $request
     */
    public function __construct(FormInterface $form, Request $request)
    {
    	$this->form = $form;
    	$this->request = $request;
    }

    /**
     * @return FormInterface
     */
    public function setFormData($name, $modelData)
    {
        return $this->form->get($name)->setData($modelData);
    }
    
    /**
     * @return string
     */
    public function getParam($param)
    {
    	return $this->request->get($param);
    }
}