<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class InterventionCountExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    private $om;
    
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public function getName()
    {
        return 'interventioncount_extension';
    }
    
    public function getGlobals()
    {
        return [
            'interventioncount' => [
                'today' => $this->om->getRepository('JLMDailyBundle:Intervention')->getCountToday(),
                'stopped' => $this->om->getRepository('JLMModelBundle:Door')->getCountStopped(),
                'fixing' => $this->om->getRepository('JLMDailyBundle:Fixing')->getCountOpened(),
                'work'   => $this->om->getRepository('JLMDailyBundle:Work')->getCountOpened(),
                'maintenance' => $this->om->getRepository('JLMDailyBundle:Maintenance')->getCountOpened(),
            ],
        ];
    }
}
