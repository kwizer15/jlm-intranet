<?php
namespace JLM\OfficeBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;

class Bill extends Document
{ 
	
    protected function getColsize()
    {
        return array(117, 12, 24, 24, 13);
    }
	
	public function _header($duplicate)
	{
		if ($this->entity->getState() == -1)
		{
			$this->setFont('Arial','B',120);
			$this->setTextColor(230);
			$this->rotatedText(40,90,'Annulée',-45);
			$this->setTextColor(0);
		}
		elseif ($this->entity->getState() == 2 || $duplicate)
		{
			$this->setFont('Arial','B',120);
			$this->setTextColor(230);
			$this->rotatedText(40,90,'Duplicata',-45);
			$this->setTextColor(0);
		}
		
		// Repères
		//$this->setFont('Arial','',8);
		//$this->cell(0,4,'Fee :'.$this->entity->getFee()->getId(),0,1);
		//$txt = 'Contracts :';
		//foreach ($this->entity->getFee()->getContracts() as $c)
		//{
		//	$txt .= $c->getId().' ';
		//}
		//$this->cell(0,4,$txt,0,1);
		
		
		$this->setFont('Arial','BU',11);
		$this->cell(0,5,'Affaire :',0,1);
		$this->setFont('Arial','',11);
		$this->multicell(0,5,$this->entity->getSite(),0);
		$this->setFont('Arial','I',11);
		$this->multicell(0,5,$this->entity->getDetails(),0);
		$this->ln(10);
		$y = $this->getY();
		$this->setXY(120,60);
		// Trustee
	//	$this->rect(86,47,99,39);
		if ($this->entity->getPrelabel())
		{
			$this->setFont('Arial','',9);
			$this->multicell(0,4,$this->entity->getPrelabel(),0);
		}
		$this->setX(120);
		$this->setFont('Arial','B',11);
		$this->cell(0,5,$this->entity->getTrusteeName(),0,2);
		$this->setX(120);
		$this->setFont('Arial','',11);
		$this->multiCell(0,5,$this->entity->getTrusteeAddress());
		
		$this->setY($y);
		// Création haut
		$this->setFont('Arial','B',10);
		$this->cell(25,6,'N° Client','LRT',0,'C',true);
		$this->cell(25,6,'Date','LRT',0,'C',true);
		$this->cell(25,6,'N° Facture','LRT',1,'C',true);
		
		// Création bas
		$this->setFont('Arial','',10);
		$this->cell(25,6,$this->entity->getAccountNumber(),'LRB',0,'C');
		$this->cell(25,6,$this->entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
		$this->cell(25,6,$this->entity->getNumber(),'LRB',1,'C');
			
		$this->ln(6);
		$this->setFont('Arial','B',11);
		$this->multicell(0,5,'Ref : '.$this->entity->getReference(),0);
		$this->ln(5);
		$this->setFont('Arial','B',10);
		if ($this->entity->getIntro())
		{
			$this->multiCell(0,6,$this->entity->getIntro(),0,1);
			$this->ln(3);
		}
	}
	
	public function tabHeader()
	{
	    $this->setFont('Arial','B',10);
	    $this->cell($this->colsize[0],6,'Désignation',1,0,'C',true);
	    $this->cell($this->colsize[1],6,'Qté',1,0,'C',true);
	    $this->cell($this->colsize[2],6,'Prix U.H.T',1,0,'C',true);
	    $this->cell($this->colsize[3],6,'Prix H.T',1,0,'C',true);
	    $this->cell($this->colsize[4],6,'TVA',1,1,'C',true);
	}
	
	public function _line($line)
	{
		
		$this->cell($this->colsize[0],8,$line->getDesignation(),'RL',0);
		$this->cell($this->colsize[1],8,$line->getQuantity(),'RL',0,'R');
		$this->cell($this->colsize[2],8,number_format($line->getUnitPrice()*(1-$line->getDiscount()),2,',',' ').' €','RL',0,'R');
		$this->cell($this->colsize[3],8,number_format($line->getPrice(),2,',',' ').' €','RL',0,'R');
		$this->cell($this->colsize[4],8,number_format($line->getVat()*100,1,',',' ').' %','RL',1,'R');
//		$this->cell(22,8,number_format($line->getPriceAti(),2,',',' ').' €','RL',1,'R');
		
		
		
		if ($line->getShowDescription())
		{
			$text = explode(chr(10),$line->getDescription());
			$y = $this->getY() - 2;
			$this->setY($y);
			$this->setFont('Arial','I',10);
			foreach ($text as $l)
			{
				$this->cell($this->colsize[0],5,$l,'RL');
				$this->cell($this->colsize[1],5,'','RL',0);
				$this->cell($this->colsize[2],5,'','RL',0);
				$this->cell($this->colsize[3],5,'','RL',0);
				$this->cell($this->colsize[4],5,'','RL',1);
			//	$this->cell(22,5,'','RL',1);
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
		if ($y > 220)
		{
			$this->addPage();
			$y = $this->getY();
		}
		$this->end = true;
		$h = 220 - $y;

		$this->cell($this->colsize[0], $h,'','RLB',0);
		$this->cell($this->colsize[1], $h,'','RLB',0);
		$this->cell($this->colsize[2],$h,'','RLB',0);
		$this->cell($this->colsize[3],$h,'','RLB',0);
		$this->cell($this->colsize[4],$h,'','RLB',1);
//		$this->cell(22,$h,'','RLB',1);
		$this->ln(6);
		// Réglement
		$this->setFont('Arial','B',10);
		$this->cell(24,6,'Base HT',1,0,'C',true);
		$this->cell(13,6,'TVA',1,0,'C',true);
		$this->cell(24,6,'Montant TVA',1,0,'C',true);
		$this->cell(51,6,'Échéance',1,0,'C',true);
		$this->cell(5,6,'',0,0);
		$this->cell(35,6,'Total HT',1,0,'R',true);
		$this->setFont('Arial','',10);
		$this->cell(38,6,number_format($this->entity->getTotalPrice(),2,',',' ').' €',1,1,'R');
		
		$y = $this->getY();
		$vats = $this->entity->getTotalVatByRate();
		foreach ( $vats as $rate=>$vat)
		{
			$this->cell(24,6,number_format($vat['base'],2,',',' ').' €','RL',0,'R');
			$this->cell(13,6,number_format($rate,1,',',' ').' %','RL',0,'R');
			$this->cell(24,6,number_format($vat['vat'],2,',',' ').' €','RL',1,'R');
		}
		$this->cell(61,6,'','T',0);
		$x = $this->getX();
		$this->setXY($x,$y);
		$maturity = $this->entity->getMaturityDate();
		if ($maturity == $this->entity->getCreation())
			$this->cell(51,6,'A réception',1,0,'C');
		else 
			$this->cell(51,6,$maturity->format('d/m/Y'),1,0,'C');
		$this->cell(5,6,'',0,0);
		$this->setFont('Arial','B',10);
		$this->cell(35,6,'Total TVA',1,0,'R',true);
		$this->setFont('Arial','',10);
		$this->cell(38,6,number_format($this->entity->getTotalVat(),2,',',' ').' €',1,1,'R');
		
		$this->setX($x);
		$this->cell(51,6,'',0,0,0);
		$this->cell(5,6,'',0,0);
		$this->setFont('Arial','B',10);
		$this->cell(35,6,'NET A PAYER',1,0,'R',true);
		$this->cell(38,6,number_format($this->entity->getTotalPriceAti(),2,',',' ').' €',1,1,'R');
		$this->ln(6);
		
		$this->setFont('Arial','',11);
		$this->cell(0,5,'En votre aimable réglement - Merci -',0,1,'R');
		$this->ln(6);
		if ($this->entity->getProperty())
		{
			$this->setFont('Arial','BU',8);
			$this->cell(30,4,'Clause de propriété',0,0);
			$this->setFont('Arial','',8);
			$this->cell(0,4,$this->entity->getProperty(),0,1);
		}
		$this->setFont('Arial','BU',8);
		$this->cell(12,4,'Pénalité',0,0);
		$this->setFont('Arial','',8);
		$this->cell(0,4,$this->entity->getPenalty(),0,1);
		$this->setFont('Arial','BU',8);
		$this->cell(15,4,'Escompte',0,0);
		$this->setFont('Arial','',8);
		$this->cell(0,4,$this->entity->getEarlyPayment(),0,1);
		
	}
	
	public function getDocumentName()
	{
	    return 'Facture';
	}
	
	protected function showPage()
	{
	}
}