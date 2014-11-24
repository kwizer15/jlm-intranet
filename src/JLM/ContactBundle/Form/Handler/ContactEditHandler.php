<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactNewHandler extends FormHandler
{
	/**
	 * @var Request
	 */
	protected $om;
	
	/**
	 * Constructor
	 * @param Form $form
	 * @param Request $request
	 * @param ObjectManager $om
	 */
	public function __construct(Form $form, Request $request, ObjectManager $om)
	{
		$this->__construct($form, $request);
		$this->om = $om;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function onSuccess()
	{
		$entity = $this->form->getData();
        $this->om->persist($entity);
        $phones = $entity->getPhones();
                foreach ($phones as $key => $phone)
                {
                	$phone->setContact($entity);
                	$this->om->persist($phone->getPhone());	// Persist Phone
                	$this->om->persist($phone);				// Persist ContactPhone
                    foreach ($originalPhones as $key => $toDel)
                    {
                        if ($toDel->getId() === $phone->getId())
                        {
                            unset($originalPhones[$key]);
                        }
                    }
                }
                foreach ($originalPhones as $phone)
                {
                    $em->remove($phone);
                    $em->remove($phone->getPhone());
                } 
                
                $em->flush();
		
		return true;
	}
}