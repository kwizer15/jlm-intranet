<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteCountExtension extends \Twig_Extension
{
    private $om;
    
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public function getName()
    {
        return 'quotecount_extension';
    }
    
    public function getGlobals()
    {
        $date = new \DateTime;
        $year = $date->format('Y');
        $repo = $this->om->getRepository('JLMCommerceBundle:Quote');
        
        return array(
            'quotecount' => array(
				'all' => $repo->getCountState('uncanceled', $year),
				'input' => $repo->getCountState(0, $year),
				'wait' => $repo->getCountState(1, $year),
				'send' => $repo->getCountState(3, $year),
				'given' => $repo->getCountState(5, $year),
            ),
            'quotelasts' => $repo->findBy(
                    array(),
                    array('number'=>'desc'),
                    5
            )
        );
    }
}
