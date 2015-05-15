<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
use JLM\ContactBundle\Model\AddressInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AddressExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'address_extension';
    }
    
    public function getFilters()
    {
        return array(
        		new \Twig_SimpleFilter('address', array($this, 'addressFilter'), array('is_safe' => array('all'))),
        );
    }
    
    public function addressFilter(AddressInterface $address)
    {
    	$cityName = strtoupper($address->getCity()->getName());
    	$cityZip = $address->getCity()->getZip();
    	$street = nl2br($address->getStreet());
    	
    	return '<strong>' . $cityName
    	     . '</strong> <small>' . $cityZip
    	     . '</small><br>' . $street;
    }
}
