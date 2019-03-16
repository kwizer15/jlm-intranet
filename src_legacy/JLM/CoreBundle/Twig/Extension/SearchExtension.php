<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Twig\Extension;

use Symfony\Component\Form\FormFactoryInterface;
use JLM\CoreBundle\Form\Type\SearchType;
use Symfony\Component\DependencyInjection\Container;
use JLM\CoreBundle\Entity\Search;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SearchExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    private $formFactory;

    public function __construct(Container $container)
    {
        $this->formFactory = $container->get('form.factory');
    }

    public function getName()
    {
        return 'search_extension';
    }

    public function getGlobals()
    {
        $form = $this->formFactory->create(SearchType::class);

        return [
            'search' => [
                'form' => $form->createView(),
            ],
        ];
    }
}
