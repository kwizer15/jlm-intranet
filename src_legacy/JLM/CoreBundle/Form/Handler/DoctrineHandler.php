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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DoctrineHandler extends FormHandler
{
    /**
     * @var Request
     */
    protected $om;

    private $entity;

    /**
     * Constructor
     *
     * @param FormInterface $form
     * @param Request $request
     * @param ObjectManager $om
     * @param null $entity
     */
    public function __construct(FormInterface $form, Request $request, ObjectManager $om, $entity = null)
    {
        parent::__construct($form, $request);
        $this->om = $om;
        $this->entity = $entity;
    }
    
    /**
     * {@inheritdoc}
     */
    public function onSuccess(): bool
    {
        switch ($this->request->getMethod()) {
            case 'GET':
                return false;
            case 'DELETE':
                $this->om->remove($this->entity);
                break;
            default:
                $this->om->persist($this->form->getData());
        }
        $this->om->flush();
        
        return true;
    }
}
