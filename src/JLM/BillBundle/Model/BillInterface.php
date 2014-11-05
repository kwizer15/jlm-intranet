<?php
namespace JLM\BillBundle\Model;

use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\Trustee;
use JLM\CommerceBundle\Model\CustomerInterface;

interface BillInterface
{
    public function setSiteObject(Site $siteObject = null);
    
    public function setSite($site);
    
    public function setTrustee(CustomerInterface $customer = null);
    public function setTrusteeName($name);
    public function setTrusteeAddress($address);
    
}