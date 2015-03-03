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
use Doctrine\Common\Persistence\ObjectManager;

class DoctrineEvent extends Event
{
    /**
     * @var Request
     */
    private $entity;

    /**
     * @param FormInterface $form
     * @param Request $request
     */
    public function __construct($entity, ObjectManager $om)
    {
    	$this->entity = $entity;
    	$this->om = $om;
    }
    
    /**
     * @return string
     */
    public function getEntity()
    {
    	return $this->entity;
    }
    
    public function getObjectManager()
    {
    	return $this->om;
    }
}