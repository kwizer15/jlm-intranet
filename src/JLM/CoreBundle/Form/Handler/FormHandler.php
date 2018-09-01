<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class FormHandler
{
    /**
     * @var Request
     */
    protected $request;
    
    /**
     * @var Form
     */
    protected $form;
    
    /**
     * Constructor
     * @param Form $form
     * @param Request $request
     */
    public function __construct(Form $form, Request $request)
    {
        $this->form = $form;
        $this->request = $request;
    }
    
    /**
     * @return bool
     */
    public function process()
    {
        $this->form->handleRequest($this->request);
        if ($this->form->isValid()) {
            return $this->onSuccess();
        }
        
        return false;
    }
    
    /**
     * @return bool
     */
    abstract public function onSuccess();
}
