<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Manager;

use JLM\CoreBundle\Manager\BaseManager as Manager;
use JLM\CommerceBundle\Form\Type\QuoteType;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CommerceBundle\Entity\Quote;
use JLM\ModelBundle\Form\Type\MailType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteManager extends Manager
{

    /**
     * {@inheritdoc}
     */
    protected function getFormParam(string $name, array $options = []): array
    {
        switch ($name) {
            case 'new':
                return [
                        'method' => 'POST',
                        'route'  => 'quote_create',
                        'params' => [],
                        'label'  => 'Créer',
                        'type'   => QuoteType::class,
                        'entity' => null,
                       ];
            case 'edit':
                return [
                        'method' => 'POST',
                        'route'  => 'quote_update',
                        'params' => ['id' => $options['entity']->getId()],
                        'label'  => 'Modifier',
                        'type'   => QuoteType::class,
                        'entity' => $options['entity'],
                       ];
        }
        
        return parent::getFormParam($name, $options);
    }
    
    /**
     * {@inheritdoc}
     */
    public function populateForm($form, Request $request)
    {
        // Appel des évenements de remplissage du formulaire
        $this->dispatch(JLMCommerceEvents::QUOTE_FORM_POPULATE, new FormPopulatingEvent($form, $request));
        
        // On complète avec ce qui reste vide
        $vat = $this->om->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate();
        $params = [
                   'creation'       => new \DateTime,
                   'vat'            => $vat,
                   'vatTransmitter' => $vat,
                   'followerCp'     => $this->getUser()->getContact()->getName(),
                  ];
        foreach ($params as $key => $value) {
            $param = $form->get($key)->getData();
            if (empty($param)) {
                $form->get($key)->setData($value);
            }
        }

        return parent::populateForm($form, $request);
    }
}
