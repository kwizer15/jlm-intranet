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

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CoreExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    public function getName()
    {
        return 'core_extension';
    }

    public function getGlobals()
    {
        return [
            'today' => new \DateTime(),
        ];
    }
}
