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

use JLM\CommerceBundle\Pdf\Quote;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteVariantSendMailBuilder extends QuoteVariantMailBuilder
{

	public function buildSubject()
	{
		$this->setSubject('Devis n°'.$this->getQuoteVariant()->getNumber());
	}
	
	public function buildBody()
	{
		$this->setBody('Bonjour,'.chr(10).chr(10)
			.'Affaire :'.chr(10)
			.$this->getQuoteVariant()->getDoor().chr(10).chr(10)
			.$this->getQuoteVariant()->getIntro().chr(10).chr(10)
			.'Cordialement'
			.$this->_getSignature()
		);
	}
	
	public function buildPreAttachements()
	{
		$filename = 'DEV'.$this->getQuoteVariant()->getNumber().'.pdf';
		$name = 'uploads/'.$filename;
		Quote::save(array($this->getQuoteVariant()), true, $name );
		$this->getMail()->addPreAttachement(new UploadedFile($name, $filename, 'application/pdf'));
		if ($this->getQuoteVariant()->getQuote()->getVat() == $this->getQuoteVariant()->getQuote()->getVatTransmitter())
		{
			$this->getMail()->addPreAttachement(new UploadedFile('bundles/jlmcommerce/pdf/attestation.pdf', 'attestation.pdf', 'application/pdf'));
		}
	}
}