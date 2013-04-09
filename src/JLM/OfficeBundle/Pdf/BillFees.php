<?php
namespace JLM\OfficeBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;

class BillFees extends FPDFext
{
	private $entity;
	
	public static function get($entities,$number)
	{
		$pdf = new self();
		$pdf->_init();
		foreach ($entities as $entity)
		{
			$pdf->addEntity($entity,$number);
			$number++;
		}
		return $pdf->Output('','S');
	}
	
	private function addEntity($entity,$number)
	{
		$this->entity = $entity;
		$this->addPage();
		$this->_header($number);
		$this->_content();
		$this->_footer();
		return $this;
	}
	
	private function _init()
	{
		
	}
	
	private function _header($number)
	{
		// Date facture
		$datef = new \DateTime();
		
		// Numéro de facture
		$billnumber = 1302;
		
		
		// Adresse de facturation
		$this->setXY(120,55);
		$this->setFont('Arial','',9);
		$this->cell(0,5,$this->entity->getDoor()->getBillingPrelabel(),0,2);
		$this->setFont('Arial','B',11);
		$this->cell(0,5,$this->entity->getTrustee(),0,2);
		$this->setFont('Arial','',11);
		$address = $this->entity->getTrustee()->getAddress();
		$billingaddress = $this->entity->getTrustee()->getBillingAddress();
		if ($billingaddress)
			if ($billingaddress->getStreet())
			$address = $billingaddress;
			
		$this->multiCell(0,5,utf8_decode($address->toString()));
		$this->cell(0,5,'',0,1);
		
		// Affaire
		$this->setFont('Arial','BU',11);
		$this->cell(0,5,'Affaire',0,2);
		$this->setFont('Arial','B',11);
		$this->cell(0,5,'Contrat d\'entretien : '.$this->entity->getNumber(),0,2);
		if ($this->entity->getDoor()->getSite()->getGroupNumber() != null)
			$this->cell(0,5,'Groupe : '.$this->entity->getDoor()->getSite()->getGroupNumber(),0,2);
		else
			$this->ln(5);
		$this->setFont('Arial','',11);
		$this->multiCell(0,5,$this->entity->getDoor()->getSite()->getAddress()->toString(),0);
		$this->ln(5);
		
		$this->cell(30,5,'N° Client',1,0);
		$this->cell(30,5,'Date Facture',1,0);
		$this->cell(30,5,'N° Facture',1,1);
		$this->cell(30,5,$this->entity->getTrustee()->getAccountNumber(),1,0,'R');
		$this->cell(30,5,$datef->format('d/m/Y'),1,0,'R');
		$this->cell(30,5,$billnumber.$number,1,1,'R');
		$this->ln(5);
		
		$this->cell(140,5,'Désignation',1,0,'C');
		$this->cell(0,5,'Montant H.T',1,1,'C');
		$this->cell(140,90,'Redevance semestielle du 01/01/2013 au 30/06/2013',1,0);
		$amount = $this->entity->getFee()/2;
		$this->cell(0,90,number_format($amount,2,',',' ').' ').chr(128,1,1,'R');
		$this->ln(5);
		
		$this->cell(55,5,'Échéance',1,0,'C');
		$this->cell(27,5,'Base H.T',1,0);
		$this->cell(30,5,'Taux T.V.A',1,0);
		$this->cell(32,5,'Montant T.V.A',1,0);
		$this->cell(0,5,'Net T.T.C',1,1);
		
		$this->cell(55,5,'A réception',1,0,'C');
		$this->cell(27,5,number_format($amount,2,',',' ').' ').chr(128,1,0,'R');
		$this->cell(30,5,$this->entity->getDoor()->getSite()->getVat(),1,0,'R');
		$tva = $amount * $this->entity->getDoor()->getSite()->getVat()->getRate();
		$this->cell(32,5,number_format($tva,2,',',' ').' ').chr(128,1,0,'R');
		$this->cell(0,5,number_format($amount + $tva,2,',',' ').' ').chr(128,1,1,'R');
		$this->ln(10);
		
		
		$this->cell(0,7,'En votre aimable réglement - Merci -',0,1);
		$this->setFont('Arial','',8);
		$this->cell(0,5,'Escompte 0,00 % pour paiement anticipé.',0,1);
		$this->cell(0,5,'Pénalité de 1,50 % par mois pour paiement différé',0,1);
	}
	
	private function _content()
	{
		
	}
	
	private function _footer()
	{
		
	}
}