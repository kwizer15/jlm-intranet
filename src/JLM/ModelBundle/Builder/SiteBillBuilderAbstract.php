<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Builder;

use JLM\CommerceBundle\Builder\BillBuilderAbstract;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\Trustee;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class SiteBillBuilderAbstract extends TrusteeBillBuilderAbstract
{
    protected $site;
    
    public function __construct(Site $site, $options = array())
    {
        $this->site = $site;
        parent::__construct($this->site->getTrustee(), $options);
    }
   
    /**
     * {@inheritdoc}
     */
    public function buildBusiness()
    {
        $this->bill->setSite($this->site->toString());
        $this->bill->setSiteObject($this->site);
        $this->bill->setPrelabel($this->site->getBillingPrelabel());
        $this->bill->setVat($this->site->getVatRate());
    }
}