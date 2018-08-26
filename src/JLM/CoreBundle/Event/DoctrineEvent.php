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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DoctrineEvent extends Event
{
    /**
     * @var mixed
     */
    private $entity;
    
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * Constructor
     * @param FormInterface $form
     * @param Request $request
     */
    public function __construct($entity, ObjectManager $om)
    {
        $this->entity = $entity;
        $this->om = $om;
    }
    
    /**
     * Get the entity
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    /**
     * Get thje object manager
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->om;
    }
}
