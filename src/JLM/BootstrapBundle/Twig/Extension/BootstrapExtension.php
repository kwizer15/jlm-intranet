<?php

/*
 * This file is part of the JLMBootstrapBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\BootstrapBundle\Twig\Extension;

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
        		new \Twig_SimpleFilter('icon', array($this, 'iconFilter'), array('is_safe' => array('all'))),
        		new \Twig_SimpleFilter('badge', array($this, 'badgeFilter'), array('is_safe' => array('all'))),
        );
    }
    
    public function iconFilter($iconName, $white = false, $version = '3.3.5')
    {
    	return '<span class="glyphicon glyphicon-'.$iconName.'"></span>';
    }
    
    public function badgeFilter($content, $class = null)
    {
    	$class = ($class === null) ? 'badge' : 'badge badge-'.$class;
    	
    	return '<span class="'.$class.'">'.$content.'</span>';
    }
        
    public function getGlobals()
    {
    	return array(
    			'twbs' => array('version' => 3),
    	);
    }
}
