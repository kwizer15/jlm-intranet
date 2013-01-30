<?php
namespace JLM\OfficeBundle\Pdf;

class BillFees extends \FPDF
{
	private $entity;
	
	public static function get($entities)
	{
		$pdf = new self();
		$pdf->_init();
		foreach ($entities as $entity)
			$pdf->addEntity($entity);
		return $pdf->Output('','S');
	}
	
	private function addEntity($entity)
	{
		$this->entity = $entity;
		$this->addPage();
		$this->_header();
		$this->_content();
		$this->_footer();
		return $this;
	}
	
	private function _init()
	{
		
	}
	
	private function _header()
	{
		// Date facture
		$datef = new \DateTime();
		
		// Numéro de facture
		$billnumber = 13020000;
		
		
		// Adresse de facturation
		$this->setXY(120,55);
		$this->setFont('Arial','',9);
		$this->cell(0,5,utf8_decode($this->entity->getDoor()->getBillingPrelabel()),0,2);
		$this->setFont('Arial','B',11);
		$this->cell(0,5,utf8_decode($this->entity->getTrustee()),0,2);
		$this->setFont('Arial','',11);
		$address = $this->entity->getTrustee()->getBillingAddress();
		if ($address === null)
			$address = $this->entity->getTrustee()->getAddress();
		$this->multiCell(0,5,utf8_decode($this->entity->getTrustee()->getBillingAddress()));
		$this->cell(0,5,'',0,1);
		
		// Affaire
		$this->setFont('Arial','BU',11);
		$this->cell(0,5,utf8_decode('Affaire'),0,2);
		$this->setFont('Arial','B',11);
		$this->cell(0,5,utf8_decode('Contrat d\'entretien : '.$this->entity->getNumber()),0,2);
		if ($this->entity->getDoor()->getSite()->getGroupNumber() != null)
			$this->cell(0,5,utf8_decode('Groupe : '.$this->entity->getDoor()->getSite()->getGroupNumber()),0,2);
		else
			$this->ln(5);
		$this->setFont('Arial','',11);
		$this->multiCell(0,5,utf8_decode($this->entity->getDoor()->getSite()->getAddress()),0);
		$this->ln(5);
		
		$this->cell(30,5,utf8_decode('N° Client'),1,0);
		$this->cell(30,5,utf8_decode('Date Facture'),1,0);
		$this->cell(30,5,utf8_decode('N° Facture'),1,1);
		$this->cell(30,5,utf8_decode($this->entity->getTrustee()->getAccountNumber()),1,0,'R');
		$this->cell(30,5,utf8_decode($datef->format('d/m/Y')),1,0,'R');
		$this->cell(30,5,utf8_decode($billnumber),1,1,'R');
		$this->ln(5);
		
		$this->cell(140,5,utf8_decode('Désignation'),1,0,'C');
		$this->cell(0,5,utf8_decode('Montant H.T'),1,1,'C');
		$this->cell(140,90,utf8_decode('Redevance semestielle du 01/01/2013 au 30/06/2013'),1,0);
		$this->cell(0,90,utf8_decode(str_replace('.',',',$this->entity->getFee()).' ').chr(128),1,1,'R');
		$this->ln(5);
		
		$this->cell(55,5,utf8_decode('Échéance'),1,0,'C');
		$this->cell(27,5,utf8_decode('Base H.T'),1,0);
		$this->cell(30,5,utf8_decode('Taux T.V.A'),1,0);
		$this->cell(32,5,utf8_decode('Montant T.V.A'),1,0);
		$this->cell(0,5,utf8_decode('Net T.T.C'),1,1);
		
		$this->cell(55,5,utf8_decode('A réception'),1,0,'C');
		$this->cell(27,5,utf8_decode(str_replace('.',',',$this->entity->getFee()).' ').chr(128),1,0,'R');
		$this->cell(30,5,utf8_decode($this->entity->getDoor()->getSite()->getVat()),1,0,'R');
		$tva = $this->entity->getFee() * $this->entity->getDoor()->getSite()->getVat()->getRate();
		$this->cell(32,5,utf8_decode(str_replace('.',',',$tva)).chr(128),1,0,'R');
		$this->cell(0,5,utf8_decode(str_replace('.',',',$this->entity->getFee() + $tva).' ').chr(128),1,1,'R');
		$this->ln(10);
		
		
		$this->cell(0,7,utf8_decode('En votre aimable réglement - Merci -'),0,1);
		$this->setFont('Arial','',8);
		$this->cell(0,5,utf8_decode('Escompte 0,00% pour paiement anticipé.'),0,1);
		$this->cell(0,5,utf8_decode('Pénalité de 1,50% par mois pour paiement différé'),0,1);
		
		
		
		
		
		
		
//	// Affaire
//	$this->setFont('Arial','BU',11);
//	//	$this->setY(63);
//	$this->cell(20,7,utf8_decode('Affaire '),0,1);
//	$this->setFont('Arial','B',11);
//	$this->cell(100,7,utf8_decode('Contrat d\'entretien : '.$this->entity->getNumber()),0,1);
//	
//	
//	if (false)
//		$this->cell(100,7,utf8_decode('Groupe : '),0,1);	// Groupe RIVP
//	
//	$this->setFont('Arial','',11);
//	$this->multiCell(100,7,utf8_decode($this->entity->getDoor()));
//	
//	
//	
//	// Door
//	$this->setFont('Arial','B',11);
//	$this->cell(15,5,utf8_decode('affaire : '),0,0);
//	$this->setFont('Arial','I',11);
//	$y = $this->getY();
//	$this->multiCell(90,5,utf8_decode($this->entity->getQuote()->getDoorCp()),0);
//	$this->setX(120);
//	// Trustee
//	//	$this->rect(86,47,99,39);
//	$this->setFont('Arial','B',11);
//	$this->cell(0,5,utf8_decode($this->entity->getQuote()->getTrusteeName()),0,2);
//	$this->setFont('Arial','',11);
//	$this->multiCell(0,5,utf8_decode($this->entity->getQuote()->getTrusteeAddress()));
//	$this->ln(10);
//
//	// Création haut
//	$this->setFont('Arial','B',10);
//	$this->cell(22,6,'Date','LRT',0,'C',true);
//	$this->cell(22,6,utf8_decode('Devis n°'),'LRT',0,'C',true);
//
//	// Contact
//	$this->setFont('Arial','',10);
//
//	$this->setX(120);
//	$this->cell(0,5,utf8_decode('à l\'attention de '.$this->entity->getQuote()->getContactCp()),0,1);
//
//	// Création bas
//	$this->setFont('Arial','',10);
//	$this->cell(22,6,$this->entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
//	$this->cell(22,6,$this->entity->getNumber(),'LRB',1,'C');
//		
//	$this->ln(6);
//	$this->multiCell(0,6,utf8_decode($this->entity->getIntro()),0,1);
//	$this->ln(3);
	}
	
	private function _content()
	{
		
	}
	
	private function _footer()
	{
		
	}
}