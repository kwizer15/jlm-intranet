<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AskQuoteCountExtension extends \Twig_Extension
{
    private $om;
    
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public function getName()
    {
        return 'askquotecount_extension';
    }
    
    public function getGlobals()
    {
        $repo = $this->om->getRepository('JLMOfficeBundle:AskQuote');
        
        return array('askquotecount' => array(
				'all' => $repo->getTotal(),
				'untreated' => $repo->getCountUntreated(),
				'treated' => $repo->getCountTreated(),
		));
    }
}
