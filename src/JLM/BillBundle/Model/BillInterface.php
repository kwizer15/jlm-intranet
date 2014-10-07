<?php
namespace JLM\BillBundle\Model;

use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\Trustee;

interface BillInterface
{
    public function setSiteObject(Site $siteObject = null);
    
    public function setSite($site);
    
    public function setTrustee(Trustee $trustee = null);
    public function setTrusteeName($name);
    public function setTrusteeAddress($address);
    
}