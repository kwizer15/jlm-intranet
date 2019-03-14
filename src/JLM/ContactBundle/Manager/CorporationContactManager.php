<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Manager;

use JLM\CoreBundle\Manager\BaseManager as Manager;
use JLM\ContactBundle\Form\Type\CorporationContactType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CorporationContactManager extends Manager
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
                    'route' => 'jlm_contact_corporationcontact_create',
                    'params' => [],
                    'label' => 'Créer',
                    'type' => new CorporationContactType(),
                    'entity' => null,
                ];
            case 'edit':
                return [
                    'method' => 'POST',
                    'route' => 'jlm_contact_corporationcontact_update',
                    'params' => ['id' => $options['entity']->getId()],
                    'label' => 'Modifier',
                    'type' => new CorporationContactType(),
                    'entity' => $options['entity'],
                ];
            case 'delete':
                return [
                    'method' => 'DELETE',
                    'route' => 'jlm_contact_corporationcontact_delete',
                    'params' => ['id' => $options['entity']->getId()],
                    'label' => 'Supprimer',
                    'type' => FormType::class,
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
        $params = [
            'corporation' => 'JLMContactBundle:Corporation',
            'person' => 'JLMContactBundle:Person',
        ];
        foreach ($params as $param => $repo) {
            if ($data = $this->setterFromRequest($param, $repo)) {
                $form->get($param)->setData($data);
            }
        }

        return $form;
    }

    public function getEditUrl($id)
    {
        return $this->router->generate('jlm_contact_corporationcontact_edit', ['id' => $id]);
    }

    public function getDeleteUrl($id)
    {
        return $this->router->generate('jlm_contact_corporationcontact_confirmdelete', ['id' => $id]);
    }
}
