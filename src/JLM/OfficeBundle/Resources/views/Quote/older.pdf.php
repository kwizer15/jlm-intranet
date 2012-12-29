<?php

class QuotePDF extends \FPDI
{
	private $entity;
	
	public static function get($entity)
	{
		$pdf = new self();
		$pdf->_init();
		$pdf->_header($entity);
		$pdf->_content($entity);
		$pdf->_footer($entity);
		return $pdf->Output('','S');
	}
	
	private function _init()
	{
		$pageCount = $this->setSourceFile($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/pdf/devis.pdf');
		$onlyPage = $this->importPage(1, '/MediaBox');
		$this->addPage();
		$this->useTemplate($onlyPage);
		$this->setFillColor(200);
		$this->setLeftMargin(4);
	}
	
	private function _header($entity)
	{
		// Follower
		$this->setFont('Arial','BU',11);
		$this->setY(63);
		$this->cell(20,7,utf8_decode('suivi par : '),0,0);
		$this->setFont('Arial','B',11);
		$this->cell(65,7,utf8_decode($entity->getFollowerCp()),0,1);
		
		// Door
		$this->setFont('Arial','BU',11);
		$this->cell(15,5,utf8_decode('affaire : '),0,0);
		$this->setFont('Arial','',11);
		$this->multiCell(90,5,utf8_decode($entity->getDoorCp()));
		
		// Trustee
		$this->setXY(130,69.5);
		$this->multiCell(80,5,utf8_decode($entity->getTrusteeName().chr(10).$entity->getTrusteeAddress()));
			
		// Contact
		$this->setFont('Arial','',10);
		$this->setXY(130,93);
		$this->cell(40,5,utf8_decode('à l\'attention de '.$entity->getContactCp()),0,1);
			
		// Création
		$this->setFont('Arial','B',10);
		$this->setY(93);
		$this->cell(22,6,'Date','LRT',0,'C',true);
		$this->cell(19,6,utf8_decode('Devis n°'),'LRT',1,'C',true);
		$this->setFont('Arial','',10);
		$this->cell(22,6,$entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
		$this->cell(19,6,$entity->getNumber(),'LRB',1,'C');
			
		$this->cell(0,3,'',0,1);
	}
	
	private function _content($entity)
	{
		// En tête lignes
		$this->setFont('Arial','B',10);
			
		$this->cell(22,6,utf8_decode('Référence'),1,0,'C',true);
		$this->cell(19,6,utf8_decode('Quantité'),1,0,'C',true);
		$this->cell(101,6,utf8_decode('Désignation'),1,0,'C',true);
		$this->cell(24.5,6,utf8_decode('Prix U.H.T'),1,0,'C',true);
		$this->cell(25,6,utf8_decode('Prix H.T'),1,1,'C',true);
		$this->setFont('Arial','',10);
		$lines = $entity->getLines();
		foreach ($lines as $line)
		{
			$this->_line($line);
		}
		
		$h=20;
		$this->cell(22,$h,'','RL',0);
		$this->cell(19,$h,'','RL',0);
		$this->cell(101,$h,'','RL',0);
		$this->cell(24.5,$h,'','RL',0);
		$this->cell(25,$h,'','RL',1);
		$this->setFont('Arial','B',10);
		$this->cell(166.5,6,'MONTANT TOTAL H.T',1,0,'R',true);
		$this->cell(25,6,number_format($entity->getTotalPrice(),2,',',' ').' '.chr(128),1,1,'R',true);
		
		$this->setFont('Arial','',10);
		$this->cell(22,6,'Tx T.V.A',1,0,'R');
		$this->cell(19,6,number_format($entity->getVat()*100,1,',',' ').' %',1,0,'R');
		$this->cell(101,6,'',1,0);
		$this->setFont('Arial','B',10);
		$this->cell(24.5,6,'montant TVA',1,0);
		$this->cell(25,6,number_format($entity->getTotalVat(),2,',',' ').' '.chr(128),1,1,'R');
		
		$this->cell(142,6,'',1,0);
		$this->cell(24.5,6,'TOTAL T.T.C',1,0);
		$this->cell(25,6,number_format($entity->getTotalPriceAti(),2,',',' ').' '.chr(128),1,1,'R');
		
		$this->cell(0,6,'',0,1);
		
	}
	
	private function _line($line)
	{
		$this->cell(22,7,utf8_decode($line->getReference()),'RL',0);
		$this->cell(19,7,$line->getQuantity(),'RL',0,'R');
		$this->cell(101,7,utf8_decode($line->getDesignation()),'RL',0);
		$this->cell(24.5,7,number_format($line->getUnitPrice()*(1-$line->getDiscount()),2,',',' ').' '.chr(128),'RL',0,'R');
		$this->cell(25,7,number_format($line->getPrice(),2,',',' ').' '.chr(128),'RL',1,'R');
		if ($line->getShowDescription())
		{
			$y = $this->getY() - 2;
			$this->setXY(45,$y);
			$this->setFont('Arial','I',10);
			$this->multiCell(101,5,utf8_decode($line->getDescription()),0,1);
			$this->setFont('Arial','',10);
			$h = $this->getY() - $y;
			$this->setY($y);
			$this->cell(22,$h,'','RL',0);
			$this->cell(19,$h,'','RL',0);
			$this->cell(101,$h,'','RL',0);
			$this->cell(24.5,$h,'','RL',0);
			$this->cell(25,$h,'','RL',1);
				
		}
	}
	
	/**
	 * Get PDF content
	 */
	public function _footer($entity)
	{
		// Observations
		$this->setFont('Arial','',10);
		$this->cell(142,6,utf8_decode('Réservé au client'),1,0,'C',true);
		$this->cell(49.5,6,utf8_decode('BON POUR ACCORD'),1,1,'C',true);
		$this->setFont('Arial','IU',10);
		$this->cell(142,6,utf8_decode('Observations éventuelles'),'LR',0,'C');
		$this->cell(49.5,6,utf8_decode('Tampon, date et signature'),'LR',1,'C');
		$this->cell(142,20,'','LRB',0);
		$this->cell(49.5,20,'','LRB',1);
	
		// Réglement
		$this->cell(0,6,'',0,1);
		$this->setFont('Arial','BU',10);
		$this->cell(0,5,utf8_decode('Réglement'),0,1);
		$this->setFont('Arial','',10);
		$this->cell(0,5,utf8_decode($entity->getPaymentRules()),0,1);
	
		// Délais
		$this->cell(0,6,'',0,1);
		$this->setFont('Arial','BU',10);
		$this->cell(0,5,utf8_decode('Délais'),0,1);
		$this->setFont('Arial','',10);
		$this->cell(0,5,utf8_decode($entity->getDeliveryRules()),0,1);
	
		// Politesse
	
		$ct = substr($entity->getContactCp(),0,2);
		if ($ct == 'M.')
			$who = 'Monsieur';
		elseif ($ct == 'Mm')
		$who = 'Madame';
		elseif ($ct == 'Ml')
		$who = 'Mademoiselle';
		else
			$who = 'Madame, Monsieur';
		$this->cell(0,6,'',0,1);
		$this->multiCell(0,5,utf8_decode('Nous vous en souhaitons bonne réception et vous prions d\'agréer, '.$who.' l\'expression de nos'.chr(10).'sentiments les meilleurs.'),0,1);
	}
}


echo QuotePDF::get($entity);
