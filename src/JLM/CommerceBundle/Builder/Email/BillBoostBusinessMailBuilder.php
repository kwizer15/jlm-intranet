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

use JLM\CommerceBundle\Pdf\Bill;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\Model\BusinessInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillBoostBusinessMailBuilder extends BusinessMailBuilder
{
	private $unpayedBills;
	
	public function __construct(BusinessInterface $business, ObjectManager $om)
	{
		parent::__construct($business);
		$this->unpayedBills = $om->getRepository('JLMCommerceBundle:BillBoost')->getBillsToBoostByBusiness($business, 3, 15, false);
		//$this->unpayedBills = $this->getBusiness()->getUnpayedBills();
		$this->hasManyUnpayedBills = sizeof($this->unpayedBills) > 1;
	}

	
	/**
	 * {@inheritdoc}
	 */
	public function buildSubject()
	{
		$s = ($this->hasManyUnpayedBills) ? 's' : '';
		$this->setSubject('Relance facture'.$s.' non payée'.$s);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildBody()
	{
		$s = '';
		$la = 'la';
		if ($this->hasManyUnpayedBills)
		{
			$s .= 's';
			$la = 'les';
		}
		$tot = 0;
		$numbers = '';
		foreach ($this->unpayedBills as $bill)
		{
			$p = $bill->getTotalPriceAti();
			$tot += $p;
			$numbers .= 'n°'.$bill->getNumber().' - '.$p.' €'.chr(10);
		}	
		$this->setBody('Bonjour,'.chr(10).chr(10)
		.'Suite à nos relances restées sans réponse de votre part concernant '.$la.' facture'.$s.' ci-jointe'.$s
		.' dont la totalité des réglements ne nous est pas encore parvenue à ce jour et dont l\'échéance est '
		.'dépassée, le montant global restant à payer s\'élevant à : '.$tot.' €'.chr(10).chr(10)
		.$numbers.chr(10)
		.'Nous vous prions de nous faire parvenir ce règlement sous 72 heures, en cas de retard de paiement,'
		.' une indémnité légale forfaitaire pour frais de recouvrement de 40 € sera appliquée.'.chr(10).chr(10)
		.'Nous vous prions d\'agréer, Madame, Monsieur, l\'expression de nos salutations distinguées.'
		.$this->_getSignature()
		);
	}
	
	public function buildPreAttachements()
	{
		foreach ($this->unpayedBills as $bill)
		{
			$name = 'uploads/FAC'.$bill->getNumber().'.pdf';
			Bill::save(array($bill), true, $name );
			$file = new UploadedFile($name, 'FAC'.$bill->getNumber().'.pdf','application/pdf');
			$this->getMail()->addPreAttachement($file);
		}
		
	}
}