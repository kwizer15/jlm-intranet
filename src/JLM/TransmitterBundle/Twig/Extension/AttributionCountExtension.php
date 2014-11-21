<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AttributionCountExtension extends \Twig_Extension
{
    private $om;
    
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public function getName()
    {
        return 'transmitterattributioncount_extension';
    }
    
    public function getGlobals()
    {
//        $repo = $this->om->getRepository('JLMTransmitterBundle:Attribution');
        
        return array('transmitterattributioncount' => array(
				'all' => 0,
		));
    }
}
