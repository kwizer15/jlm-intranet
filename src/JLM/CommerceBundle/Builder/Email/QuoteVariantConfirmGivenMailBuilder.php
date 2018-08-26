<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Builder\Email;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteVariantConfirmGivenMailBuilder extends QuoteVariantMailBuilder
{

    public function buildSubject()
    {
        $this->setSubject('Confirmation de réception de votre accord sur devis n°'.$this->getQuoteVariant()->getNumber());
    }
    
    public function buildBody()
    {
        $this->setBody('Bonjour,'.chr(10).chr(10)
        .'Nous accusons bonne réception de votre accord sur le devis n°'.$this->getQuoteVariant()->getNumber().'.'.chr(10)
        .'Nous vous tiendrons informé de la date d\'exécution des travaux.'.chr(10).chr(10)
        .'Cordialement'
        .$this->_getSignature());
    }
}
