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
class QuoteSendMailBuilder extends QuoteMailBuilder
{

	public function buildSubject()
	{
		$this->setSubject('Devis n°'.$this->getQuote()->getNumber());
	}
	
	public function buildBody()
	{
		$desc = $this->getQuote()->getDescription().chr(10);
		foreach ($this->getQuote()->getSendableVariants() as $variant)
		{
			$desc .= 'Devis n°'.$variant->getNumber().' : '.$variant->getIntro().chr(10);
		}
		
		$this->setBody('Bonjour,'.chr(10).chr(10)
			.'Affaire :'.chr(10)
			.$this->getQuote()->getDoorCp().chr(10).chr(10)
			.$desc.chr(10)
			.'Cordialement'
			.$this->_getSignature()
		);
	}
	
	public function buildPreAttachements()
	{
		foreach ($this->getQuote()->getSendableVariants() as $variant)
		{
			$filename = 'DEV'.$variant->getNumber().'.pdf';
			$name = 'uploads/'.$filename;
			Quote::save(array($variant), true, $name );
			$this->getMail()->addPreAttachement(new UploadedFile($name, $filename, 'application/pdf'));
		}
		if ($this->getQuote()->getVat() == $this->getQuote()->getVatTransmitter())
		{
			$this->getMail()->addPreAttachement(new UploadedFile('bundles/jlmcommerce/pdf/attestation.pdf', 'attestation.pdf', 'application/pdf'));
		}
	}
}