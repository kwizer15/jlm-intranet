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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class SiteBillBuilderAbstract extends TrusteeBillBuilderAbstract
{
    protected $site;
    
    public function __construct(Site $site, $options = [])
    {
        $this->site = $site;
        parent::__construct($this->site->getManager(), $options);
    }
   
    /**
     * {@inheritdoc}
     */
    public function buildBusiness()
    {
        $site = $this->site;
        if ($site instanceof Site) {
            $this->getBill()->setSite($site->toString());
            $this->getBill()->setSiteObject($site);
            $this->getBill()->setPrelabel($site->getBillingPrelabel());
            $this->getBill()->setVat($site->getVat()->getRate());
        } else {
            $this->getBill()->setSite('');
        }
    }
}
