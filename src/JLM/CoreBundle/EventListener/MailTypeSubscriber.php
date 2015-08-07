<?php

/*
 * This file is part of the JLMCoreBundle package.
*
* (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace JLM\CoreBundle\EventListener;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use JLM\CoreBundle\JLMCoreEvents;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class MailTypeSubscriber implements EventSubscriberInterface
{
	/**
	 * @var EventDispatcherInterface
	 */
	private $dispatcher;
	
	/**
	 * @var SwiftMa
	 */
	private $mailer;

	/**
	 * @param ObjectManager $om
	 * @param EventDispatcherInterface $dispatcher
	 */
	public function __construct($mailer, EventDispatcherInterface $dispatcher)
	{
		$this->mailer = $mailer;
		$this->dispatcher = $dispatcher;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return array(
			FormEvents::PRE_SET_DATA => 'onPreSetData',
			FormEvents::POST_SUBMIT => 'onPostSubmit',
		);
	}

	/**
	 * @param FormEvent $event
	 */
	public function onPreSetData(FormEvent $event)
	{
		$this->dispatcher->dispatch(JLMCoreEvents::EMAIL_PRE_SET_DATA, $event);
	}
	
	public function onPostSubmit(FormEvent $event)
	{
		$this->dispatcher->dispatch(JLMCoreEvents::EMAIL_PRESEND, $event);
		$this->mailer->send(MailFactory::create(new MailSwiftMailBuilder($event->getData())));
		$this->dispatcher->dispatch(JLMCoreEvents::EMAIL_POSTSEND, $event);
	}
}