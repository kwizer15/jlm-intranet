<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use JLM\CommerceBundle\Model\BillInterface;
use JLM\CoreBundle\Event\RequestEvent;
use JLM\ModelBundle\Entity\Door;

class DoorEvent extends RequestEvent
{
    /**
     * @var BillInterface
     */
    private $door;

    /**
     * @param FormInterface $form
     * @param Request $request
     */
    public function __construct(Door $door, Request $request)
    {
        $this->door = $door;
        parent::__construct($request);
    }
    
    public function getDoor()
    {
        return $this->door;
    }
}
