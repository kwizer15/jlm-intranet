<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Manager;

use JLM\CoreBundle\Manager\BaseManager as Manager;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\ModelBundle\Form\Type\MailType;
use JLM\CommerceBundle\Form\Type\QuoteVariantType;
use JLM\CommerceBundle\Entity\QuoteLine;
use JLM\CommerceBundle\Entity\Quote;
use Symfony\Component\Form\Exception\LogicException;
use JLM\CommerceBundle\Model\QuoteVariantInterface;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteVariantManager extends Manager
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
                    'route' => 'variant_create',
                    'params' => [],
                    'label' => 'Créer',
                    'entry_type' => QuoteVariantType::class,
                    'entity' => null,
                ];
            case 'edit':
                return [
                    'method' => 'POST',
                    'route' => 'variant_update',
                    'params' => ['id' => $options['entity']->getId()],
                    'label' => 'Modifier',
                    'entry_type' => QuoteVariantType::class,
                    'entity' => $options['entity'],
                ];
        }

        return parent::getFormParam($name, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function populateForm($form)
    {
        // Appel des évenements de remplissage du formulaire
        $this->dispatch(
            JLMCommerceEvents::QUOTEVARIANT_FORM_POPULATE,
            new FormPopulatingEvent($form, $this->getRequest())
        );
        $quote = $form->get('quote')->getData();
        if (!$quote instanceof Quote) {
            throw new LogicException('$quote is not a Quote object');
        }

        $form->get('vat')->setData(number_format($quote->getVat() * 100, 1, ',', ' '));
        $form->get('vatTransmitter')->setData(number_format($quote->getVatTransmitter() * 100, 1, ',', ' '));

        // On complète avec ce qui reste vide
        $params = [
            'creation' => new \DateTime(),
            'discount' => 0,
        ];
        foreach ($params as $key => $value) {
            $param = $form->get($key)->getData();
            if (empty($param)) {
                $form->get($key)->setData($value);
            }
        }

        $lines = $form->get('lines')->getData();
        if (empty($lines)) {
            $l = new QuoteLine();
            $l->setVat($form->get('quote')->getData()->getVat());
            $form->get('lines')->setData([$l]);
        }

        return parent::populateForm($form);
    }

    public function assertState(QuoteVariantInterface $variant, $states = [])
    {
        if (!in_array($variant->getState(), $states)) {
            throw new Exception('This action is impossible with the actual quote state');
        }
    }
}
