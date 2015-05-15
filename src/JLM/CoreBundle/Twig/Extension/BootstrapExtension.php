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
class BootstrapExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'bootstrap_extension';
    }
    
    public function getFilters()
    {
        return array(
        		new \Twig_SimpleFilter('icon', array($this, 'iconFilter'), array('is_safe' => array('html'))),
        		new \Twig_SimpleFilter('badge', array($this, 'badgeFilter'), array('is_safe' => array('html'))),
        );
    }
    
    public function iconFilter($iconName)
    {
    	return '<span class="glyphicon glyphicon-'.$iconName.'"></span>';
    }
    
    public function badgeFilter($content)
    {
    	return '<span class="badge">'.$content.'</span>';
    }
}
