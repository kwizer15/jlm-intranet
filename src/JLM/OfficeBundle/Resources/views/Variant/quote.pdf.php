<?php

echo QuotePDF::get($entity);

class QuotePDF extends \FPDF
{
	private $entity;
	private $end = false;
	
	public static function get($entity)
	{
		
		$pdf = new self();
		$pdf->setEntity($entity);
		$pdf->_init();
		$pdf->_header();
		$pdf->_content();
		$pdf->_footer();
		return $pdf->Output('','S');
	}
	
	private function setEntity($entity)
	{
		$this->entity = $entity;
		return $this;
	}
	
	private function _init()
	{
		$this->aliasNbPages();
		$this->setFillColor(200);
	//	$pageCount = $this->setSourceFile($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/pdf/devis.pdf');
	//	$onlyPage = $this->importPage(1, '/MediaBox');
		$this->addPage();
	//	$this->useTemplate($onlyPage);
		
	//	$this->setLeftMargin(4);
	}
	
	private function _header()
	{
		// Follower
		$this->setFont('Arial','B',11);
	//	$this->setY(63);
		$this->cell(20,7,utf8_decode('suivi par : '),0,0);
		$this->setFont('Arial','B',11);
		$this->cell(65,7,utf8_decode($this->entity->getQuote()->getFollowerCp()),0,1);
		
		// Door
		$this->setFont('Arial','B',11);
		$this->cell(15,5,utf8_decode('affaire : '),0,0);
		$this->setFont('Arial','I',11);
		$y = $this->getY();
		$this->multiCell(90,5,utf8_decode($this->entity->getQuote()->getDoorCp()),0);
		$this->setXY(120,$y);
		// Trustee
	//	$this->rect(86,47,99,39);
		$this->setFont('Arial','B',11);
		$this->cell(0,5,utf8_decode($this->entity->getQuote()->getTrusteeName()),0,2);
		$this->setFont('Arial','',11);
		$this->multiCell(0,5,utf8_decode($this->entity->getQuote()->getTrusteeAddress()));
		$this->ln(10);
		
		// Création haut
		$this->setFont('Arial','B',10);
		$this->cell(22,6,'Date','LRT',0,'C',true);
		$this->cell(22,6,utf8_decode('Devis n°'),'LRT',0,'C',true);
		
		// Contact
		$this->setFont('Arial','',10);
		
		$this->setX(120);
		$this->cell(0,5,utf8_decode('à l\'attention de '.$this->entity->getQuote()->getContactCp()),0,1);
		
		// Création bas
		$this->setFont('Arial','',10);
		$this->cell(22,6,$this->entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
		$this->cell(22,6,$this->entity->getNumber(),'LRB',1,'C');
			
		$this->ln(6);
		$this->multiCell(0,6,utf8_decode($this->entity->getIntro()),0,1);
		$this->ln(3);
	}
	
	private function _content()
	{
		// En tête lignes
		$this->setFont('Arial','B',10);
			
		$this->cell(22,6,utf8_decode('Référence'),1,0,'C',true);
		$this->cell(100,6,utf8_decode('Désignation'),1,0,'C',true);
		$this->cell(7,6,utf8_decode('Qté'),1,0,'C',true);	
		$this->cell(25,6,utf8_decode('Prix U.H.T'),1,0,'C',true);
		$this->cell(13,6,utf8_decode('TVA'),1,0,'C',true);
		$this->cell(25,6,utf8_decode('Prix H.T'),1,1,'C',true);
		$this->setFont('Arial','',10);
		$lines = $this->entity->getLines();
		foreach ($lines as $line)
		{
			$this->_line($line);
		}	
	}
	
	private function _line($line)
	{
		
		$this->cell(22,8,utf8_decode($line->getReference()),'RL',0);
		$this->cell(100,8,utf8_decode($line->getDesignation()),'RL',0);
		$this->cell(7,8,$line->getQuantity(),'RL',0,'R');
		$this->cell(25,8,number_format($line->getUnitPrice()*(1-$line->getDiscount()),2,',',' ').' '.chr(128),'RL',0,'R');
		$this->cell(13,8,utf8_decode(number_format($line->getVat()*100,1,',',' ').' %'),'RL',0,'R');
		$this->cell(25,8,number_format($line->getPrice(),2,',',' ').' '.chr(128),'RL',1,'R');
		
		
		if ($line->getShowDescription())
		{
			$text = explode(chr(10),$line->getDescription());
			$y = $this->getY() - 2;
			$this->setY($y);
			$this->setFont('Arial','I',10);
			foreach ($text as $l)
			{
				$this->cell(22,5,'','RL',0);
				$this->cell(100,5,utf8_decode($l),'RL');
				$this->cell(7,5,'','RL',0);
				$this->cell(25,5,'','RL',0);
				$this->cell(13,5,'','RL',0);
				$this->cell(25,5,'','RL',1);
			}
			$this->setFont('Arial','',10);
		}
	}
	
	/**
	 * Get PDF content
	 */
	public function _footer()
	{
		$y = $this->getY();
		if ($y > 210)
		{
			$this->addPage();
			$y = $this->getY();
		}
		$this->end = true;
		$h = 210 - $y;
		$this->cell(22,$h,'','RL',0);
		$this->cell(100,$h,'','RL',0);
		$this->cell(7,$h,'','RL',0);
		$this->cell(25,$h,'','RL',0);
		$this->cell(13,$h,'','RL',0);
		$this->cell(25,$h,'','RL',1);
		
		// Réglement
		$this->setFont('Arial','B',10);
		$this->cell(167,6,'MONTANT TOTAL H.T',1,0,'R',true);
		$this->cell(25,6,number_format($this->entity->getTotalPrice(),2,',',' ').' '.chr(128),1,1,'R',true);
		
		$this->setFont('Arial','B',10);
		if ($this->entity->getQuote()->getVat() > 0.1)
			$this->cell(142,6,utf8_decode('Si T.V.A. à 7,0 %, merci de nous fournir l\'attestation'),1,0);
		else $this->cell(142,6,'',1,0);
		
		
		$this->cell(25,6,'montant TVA',1,0);
		$this->cell(25,6,number_format($this->entity->getTotalVat(),2,',',' ').' '.chr(128),1,1,'R');
		
		$this->cell(142,6,'',1,0);
		$this->cell(25,6,'TOTAL T.T.C',1,0);
		$this->cell(25,6,number_format($this->entity->getTotalPriceAti(),2,',',' ').' '.chr(128),1,1,'R');
		
		$this->ln(6);
		
		$y = $this->getY();
		$this->setFont('Arial','BU',10);
		$this->cell(142,5,utf8_decode('Réglement'),0,1);
		$this->setFont('Arial','',10);
		$this->cell(142,5,utf8_decode($this->entity->getPaymentRules()),0,1);
	
		// Délais
		$this->ln(3);
		$this->setFont('Arial','BU',10);
		$this->cell(0,5,utf8_decode('Délais'),0,1);
		$this->setFont('Arial','',10);
		$this->cell(0,5,utf8_decode($this->entity->getDeliveryRules()),0,1);
		
		// Politesse
		
		$ct = substr($this->entity->getQuote()->getContactCp(),0,2);
		if ($ct == 'M.')
			$who = 'Monsieur';
		elseif ($ct == 'Mm')
		$who = 'Madame';
		elseif ($ct == 'Ml')
		$who = 'Mademoiselle';
		else
			$who = 'Madame, Monsieur';
		$this->ln(3);
		$this->multiCell(142,5,utf8_decode('Nous vous en souhaitons bonne réception et vous prions d\'agréer, '.$who.' l\'expression de nos sentiments les meilleurs.'),0,1);
		
		// Signature
		$this->setFont('Arial','',10);
		$this->setXY(152,$y);
		$this->cell(50,6,utf8_decode('BON POUR ACCORD'),1,1,'C',true);
		$this->setFont('Arial','IU',10);
		$this->setX(152);
		$this->cell(50,6,utf8_decode('Tampon, date et signature'),'LR',1,'C');
		$this->setX(152);
		$this->cell(50,25,'','LRB',1);
		
	}
	
	public function header()
	{
		if ($this->pageNo() == 1)
		{
			$this->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-header.jpg',10,4,190);
			$this->setFont('Arial','B',24);
			$this->cell(60,35,'DEVIS',0,1,'C');
			$this->ln(5);
		}
		else
		{
			// Création
			$this->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-logo.jpg',90,4,30);
			$this->setFont('Arial','B',20);
			$this->cell(60,12,'DEVIS',0,0,'L');
			$this->cell(89,6);
			$this->setFont('Arial','B',10);
			$this->cell(22,6,'Date','LRT',0,'C',true);
			$this->cell(19,6,utf8_decode('Devis n°'),'LRT',1,'C',true);
			$this->setFont('Arial','',10);
			$this->cell(149,6);
			$this->cell(22,6,$this->entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
			$this->cell(19,6,$this->entity->getNumber(),'LRB',1,'C');
			$this->ln(6);
			$this->setFont('Arial','B',10);
				
			$this->cell(22,6,utf8_decode('Référence'),1,0,'C',true);
			$this->cell(19,6,utf8_decode('Quantité'),1,0,'C',true);
			$this->cell(101,6,utf8_decode('Désignation'),1,0,'C',true);
			$this->cell(25,6,utf8_decode('Prix U.H.T'),1,0,'C',true);
			$this->cell(25,6,utf8_decode('Prix H.T'),1,1,'C',true);
			$this->setFont('Arial','',10);
		}
	}
	
	public function footer()
	{
		$this->ln(0);
		if (!$this->end)
		{
			$y = $this->getY();
			$h = 278 - $y;
			$this->cell(22,$h,'','RLB',0);
			$this->cell(19,$h,'','RLB',0);
			$this->cell(101,$h,'','RLB',0);
			$this->cell(25,$h,'','RLB',0);
			$this->cell(25,$h,'','RLB',1);
		}
	
		$this->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-footer.jpg',50,280,110);
		$this->SetY(-15);
		// Police Arial italique 8
		$this->SetFont('Arial','',12);
		// Numéro de page
		$this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'R');
		
	}
}