<?php
namespace JLM\OfficeBundle\Pdf;

class Bill extends \FPDF
{
	private $entity;
	private $end = false;
	private $head = true;
	
	private $angle = 0;
	
	public static function get($entities)
	{
		
		$pdf = new self();
		$pdf->_init();
		foreach ($entities as $entity)
			$pdf->addEntity($entity);
		return $pdf->Output('','S');
	}
	
	public function addEntity($entity)
	{
		$this->entity = $entity;
		$this->addPage();
		$this->_header();
		$this->_content();
		$this->_footer();
		return $this;
	}
	
	public function _init()
	{
		$this->aliasNbPages();
		$this->setFillColor(200);
	}
	
	public function _header()
	{
		if ($this->entity->getState() == -1)
		{
			$this->setFont('Arial','B',120);
			$this->setTextColor(230);
			$this->rotatedText(40,90,utf8_decode('Annulée'),-45);
			$this->setTextColor(0);
		}
		elseif ($this->entity->getState() == 3)
		{
			$this->setFont('Arial','B',120);
			$this->setTextColor(230);
			$this->rotatedText(40,90,utf8_decode('Duplicata'),-45);
			$this->setTextColor(0);
		}
		$this->setFont('Arial','B',11);
		$this->multicell(0,5,utf8_decode($this->entity->getReference()),0);
		$this->ln(5);
		$this->setFont('Arial','BU',11);
		$this->cell(0,5,utf8_decode('Affaire :'),0,1);
		$this->setFont('Arial','',11);
		$this->multicell(0,5,utf8_decode($this->entity->getSite()),0);
		$this->setFont('Arial','I',11);
		$this->multicell(0,5,utf8_decode($this->entity->getDetails()),0);
		$this->ln(10);
		$y = $this->getY();
		$this->setXY(120,60);
		// Trustee
	//	$this->rect(86,47,99,39);
		if ($this->entity->getPrelabel())
		{
			$this->setFont('Arial','',9);
			$this->multicell(0,4,utf8_decode($this->entity->getPrelabel()),0);
		}
		$this->setX(120);
		$this->setFont('Arial','B',11);
		$this->cell(0,5,utf8_decode($this->entity->getTrusteeName()),0,2);
		$this->setX(120);
		$this->setFont('Arial','',11);
		$this->multiCell(0,5,utf8_decode($this->entity->getTrusteeAddress()));
		
		$this->setY($y);
		// Création haut
		$this->setFont('Arial','B',10);
		$this->cell(25,6,utf8_decode('N° Client'),'LRT',0,'C',true);
		$this->cell(25,6,utf8_decode('Date'),'LRT',0,'C',true);
		$this->cell(25,6,utf8_decode('N° Facture'),'LRT',1,'C',true);
		
		// Création bas
		$this->setFont('Arial','',10);
		$this->cell(25,6,$this->entity->getAccountNumber(),'LRB',0,'C');
		$this->cell(25,6,$this->entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
		$this->cell(25,6,$this->entity->getNumber(),'LRB',1,'C');
			
		$this->ln(6);
		if ($this->entity->getIntro())
		{
			$this->multiCell(0,6,utf8_decode($this->entity->getIntro()),0,1);
			$this->ln(3);
		}
	}
	
	public function _content()
	{
		// En tête lignes
		$this->setFont('Arial','B',10);
			
		$this->cell(100,6,utf8_decode('Désignation'),1,0,'C',true);
		$this->cell(7,6,utf8_decode('Qté'),1,0,'C',true);	
		$this->cell(24,6,utf8_decode('Prix U.H.T'),1,0,'C',true);
		$this->cell(24,6,utf8_decode('Prix H.T'),1,0,'C',true);
		$this->cell(13,6,utf8_decode('TVA'),1,0,'C',true);
		$this->cell(24,6,utf8_decode('Prix TTC'),1,1,'C',true);
		$this->setFont('Arial','',10);
		$lines = $this->entity->getLines();
		foreach ($lines as $line)
		{
			$this->_line($line);
		}	
	}
	
	public function _line($line)
	{
		
		$this->cell(100,8,utf8_decode($line->getDesignation()),'RL',0);
		$this->cell(7,8,$line->getQuantity(),'RL',0,'R');
		$this->cell(24,8,number_format($line->getUnitPrice()*(1-$line->getDiscount()),2,',',' ').' '.chr(128),'RL',0,'R');
		$this->cell(24,8,number_format($line->getPrice(),2,',',' ').' '.chr(128),'RL',0,'R');
		$this->cell(13,8,utf8_decode(number_format($line->getVat()*100,1,',',' ').' %'),'RL',0,'R');
		$this->cell(24,8,number_format($line->getPriceAti(),2,',',' ').' '.chr(128),'RL',1,'R');
		
		
		
		if ($line->getShowDescription())
		{
			$text = explode(chr(10),$line->getDescription());
			$y = $this->getY() - 2;
			$this->setY($y);
			$this->setFont('Arial','I',10);
			foreach ($text as $l)
			{
				$this->cell(100,5,utf8_decode($l),'RL');
				$this->cell(7,5,'','RL',0);
				$this->cell(24,5,'','RL',0);
				$this->cell(24,5,'','RL',0);
				$this->cell(13,5,'','RL',0);
				$this->cell(24,5,'','RL',1);
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
		if ($y > 230)
		{
			$this->addPage();
			$y = $this->getY();
		}
		$this->end = true;
		$h = 230 - $y;

		$this->cell(100,$h,'','RLB',0);
		$this->cell(7,$h,'','RLB',0);
		$this->cell(24,$h,'','RLB',0);
		$this->cell(24,$h,'','RLB',0);
		$this->cell(13,$h,'','RLB',0);
		$this->cell(24,$h,'','RLB',1);
		$this->ln(6);
		// Réglement
		$this->setFont('Arial','B',10);
		$this->cell(40,6,utf8_decode('Échéance'),1,0,'C',true);
		$this->cell(38,6,utf8_decode('Base H.T'),1,0,'C',true);
		$this->cell(38,6,utf8_decode('Taux T.V.A'),1,0,'C',true);
		$this->cell(38,6,utf8_decode('Montant T.V.A'),1,0,'C',true);
		$this->cell(38,6,utf8_decode('Net T.T.C'),1,1,'C',true);
		$maturity = $this->entity->getMaturity();
		if ($maturity == null)
			$this->cell(40,6,utf8_decode('A réception'),1,0,'C');
		else 
			$this->cell(40,6,$this->entity->getMaturity()->format('d/m/Y'),1,0,'C');
		$this->cell(38,6,number_format($this->entity->getTotalPrice(),2,',',' ').' '.chr(128),1,0,'R');
		$this->cell(38,6,number_format($this->entity->getVat()*100,1,',',' ').' %',1,0,'R');
		$this->cell(38,6,number_format($this->entity->getTotalVat(),2,',',' ').' '.chr(128),1,0,'R');
		$this->cell(38,6,number_format($this->entity->getTotalPriceAti(),2,',',' ').' '.chr(128),1,1,'R');
		
		$this->setFont('Arial','B',10);
		if ($this->entity->getVat() > 0.1)
			$this->cell(0,6,utf8_decode('Si T.V.A. à 7,0 %, merci de nous fournir l\'attestation'),1,0);
		$this->ln(6);
		
		$y = $this->getY();
		
		$this->setFont('Arial','',11);
		$this->cell(0,5,utf8_decode('En votre aimable réglement - Merci -'),0,1);
		$this->ln(6);
		if ($this->entity->getProperty())
		{
			$this->setFont('Arial','BU',8);
			$this->cell(30,4,utf8_decode('Clause de propriété'),0,0);
			$this->setFont('Arial','',8);
			$this->cell(0,4,utf8_decode($this->entity->getProperty()),0,1);
		}
		$this->setFont('Arial','BU',8);
		$this->cell(12,4,utf8_decode('Pénalité'),0,0);
		$this->setFont('Arial','',8);
		$this->cell(0,4,utf8_decode($this->entity->getPenalty()),0,1);
		$this->setFont('Arial','BU',8);
		$this->cell(15,4,utf8_decode('Escompte'),0,0);
		$this->setFont('Arial','',8);
		$this->cell(0,4,utf8_decode($this->entity->getEarlyPayment()),0,1);
		
	}
	
	public function header()
	{
		if (true) //$this->pageNo() == $this->variantpage )
		{
			$this->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-header-comp.jpg',10,4,190);
			$this->setFont('Arial','B',24);
			$this->cell(60,35,'FACTURE',0,1,'C');
			$this->ln(5);
		}
		else
		{
			
			// Création
			$this->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-logo-comp.jpg',90,4,30);
			$this->setFont('Arial','B',20);
			$this->cell(60,12,'FACTURE',0,0,'L');
			$this->cell(89,6);
			$this->setFont('Arial','B',10);
			$this->cell(22,6,'Date','LRT',0,'C',true);
			$this->cell(19,6,utf8_decode('Facture n°'),'LRT',1,'C',true);
			$this->setFont('Arial','',10);
			$this->cell(149,6);
			$this->cell(22,6,$this->entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
			$this->cell(19,6,$this->entity->getNumber(),'LRB',1,'C');
			$this->ln(6);
			$this->setFont('Arial','B',10);
				
			$this->cell(22,6,utf8_decode('Référence'),1,0,'C',true);
			$this->cell(100,6,utf8_decode('Désignation'),1,0,'C',true);
			$this->cell(7,6,utf8_decode('Qté'),1,0,'C',true);
			
			$this->cell(25,6,utf8_decode('Prix U.H.T'),1,0,'C',true);
			$this->cell(13,6,utf8_decode('TVA'),1,0,'C',true);
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
			$this->cell(100,$h,'','RLB',0);
			$this->cell(7,$h,'','RLB',0);
			$this->cell(25,$h,'','RLB',0);
			$this->cell(13,$h,'','RLB',0);
			$this->cell(25,$h,'','RLB',1);
		}
	
		$this->image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-footer.jpg',50,280,110);
		$this->setY(-15);
		// Police Arial italique 8
		$this->setFont('Arial','',12);
		// Numéro de page
		$this->cell(0,10,$this->PageNo().'/{nb}',0,0,'R');
	}
	
	public function rotate($angle,$x=-1,$y=-1)
	{
		if($x==-1)
			$x=$this->x;
		if($y==-1)
			$y=$this->y;
		if($this->angle!=0)
			$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0)
		{
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}
	
	public function rotatedText($x,$y,$txt,$angle)
	{
		//Rotation du texte autour de son origine
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}
}