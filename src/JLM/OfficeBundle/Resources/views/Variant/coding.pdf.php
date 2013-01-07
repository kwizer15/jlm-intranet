<?php

echo CodingPDF::get($entity);

class CodingPDF extends \FPDF
{
	private $entity;
	private $end = false;
	
	public static function get($entity)
	{
	
		$pdf = new self();
		$pdf->setEntity($entity);
		$pdf->_init();

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
		$this->addPage('L');

		$content = array();
		$fill = array();
		$content[] = array('',utf8_decode(str_replace(chr(10),' / ',$this->entity->getQuote()->getDoorCp())),'','','','','','','','','','','');
		$content[] = array('',$this->entity->getQuote()->getCreation()->format('d/m/Y'),'','','','','','','','','','','');
		$content[] = array('Q','fourniture','PA','taux','remise','PU','frais','port','PAHT','coef','marge','PU HT','PVHT');
		$content[] = array('','','','','','','','','','','','','');
		
		$fill[] = array(255,204,153);
		$fill[] = array(255,204,153);
		$fill[] = array(252,213,180);
		$fill[] = array(252,213,180);
		
		
		$totalpurchase = 0;
		$totalsell = 0;
		foreach ($this->entity->getLines() as $line)
		{
			if (!$line->isService())
			{
				try { $p =($line->getUnitPrice()-$line->getShipping())/($line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1))*100; }
				catch (Exception $e) { $p= 0; }
				$content[] = array(
						number_format($line->getQuantity(),0,',',' '),
						utf8_decode($line->getDesignation()),
						number_format($line->getPurchasePrice(),2,',',' ').' '.chr(128),
						number_format($line->getDiscountSupplier()*100,0,',',' ').' %',
						number_format($line->getPurchasePrice()*$line->getDiscountSupplier(),2,',',' ').' '.chr(128),
						number_format($line->getPurchasePrice()*(1-$line->getDiscountSupplier()),2,',',' ').' '.chr(128),
						number_format($line->getExpenseRatio()+1,1,',',' '),
						number_format($line->getShipping(),2,',',' ').' '.chr(128),
						number_format($line->getQuantity()*$line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping(),2,',',' ').' '.chr(128),
						number_format($p,0,',',' ').' %',
						number_format($line->getQuantity()*($line->getUnitPrice()-($line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping())),2,',',' ').' '.chr(128),
						number_format($line->getUnitPrice(),2,',',' ').' '.chr(128),
						number_format($line->getQuantity()*$line->getUnitPrice(),2,',',' ').' '.chr(128),
					);
				$totalpurchase += $line->getQuantity()*$line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping();
				$totalsell += $line->getQuantity()*$line->getUnitPrice();
				$fill[] = array(255,255,255);
			}
		}
		$content[] = array('','achat','','','','','','',number_format($totalpurchase,2,',',' ').' '.chr(128),'','','',number_format($totalsell,2,',',' ').' '.chr(128));
		$fill[] = array(192,192,192);
		foreach ($this->entity->getLines() as $line)
		{
			if ($line->isService())
			{
				$content[] = array(
						number_format($line->getQuantity(),0,',',' '),
						utf8_decode($line->getDesignation()),
						number_format($line->getPurchasePrice(),2,',',' ').' '.chr(128),
						number_format($line->getDiscountSupplier()*100,0,',',' ').' %',
						number_format($line->getPurchasePrice()*$line->getDiscountSupplier(),2,',',' ').' '.chr(128),
						number_format($line->getPurchasePrice()*(1-$line->getDiscountSupplier()),2,',',' ').' '.chr(128),
						number_format($line->getExpenseRatio()+1,1,',',' '),
						number_format($line->getShipping(),2,',',' ').' '.chr(128),
						number_format($line->getQuantity()*$line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping(),2,',',' ').' '.chr(128),
						number_format(($line->getUnitPrice()-$line->getShipping())/($line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1))*100,0,',',' ').' %',
						number_format($line->getQuantity()*($line->getUnitPrice()-($line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping())),2,',',' ').' '.chr(128),
						number_format($line->getUnitPrice(),2,',',' ').' '.chr(128),
						number_format($line->getQuantity()*$line->getUnitPrice(),2,',',' ').' '.chr(128),
				);
				$totalpurchase += $line->getQuantity()*$line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping();
				$totalsell += $line->getQuantity()*$line->getUnitPrice();
				$fill[] = array(255,255,255);
			}
		}
		$content[] = array('','total','','','','','','',number_format($totalpurchase,2,',',' ').' '.chr(128),'','','',number_format($totalsell,2,',',' ').' '.chr(128));
		$fill[] = array(255,255,0);
		$content[] = array('',
				utf8_decode('PV'),
				utf8_decode('remise %'),
				number_format($this->entity->getDiscount(),0,',',' ').' %',
				number_format($totalsell*$this->entity->getDiscount(),2,',',' ').' '.chr(128),
				'',
				'',
				'',
				'',
				utf8_decode('reste'),
				number_format(($totalsell*(1-$this->entity->getDiscount()))-$totalpurchase,2,',',' ').' '.chr(128),
				'PV',
				number_format($totalsell*(1-$this->entity->getDiscount()),2,',',' ').' '.chr(128)
			);
		$fill[] = array(184,204,228);
		
		foreach ($content as $key=>$c)
		{
			$this->setFont('Arial','',10);
			$this->setFillColor($fill[$key][0],$fill[$key][1],$fill[$key][2]);
			$this->cell(10,6,$c[0],1,0,'R',1);
			$this->cell(80,6,$c[1],1,0,'L',1);
			$this->cell(20,6,$c[2],1,0,($key < 4 ? 'L':'R'),1);
			$this->cell(10,6,$c[3],1,0,($key < 4 ? 'L':'R'),1);
			$this->cell(20,6,$c[4],1,0,($key < 4 ? 'L':'R'),1);
			$this->cell(20,6,$c[5],1,0,($key < 4 ? 'L':'R'),1);
			$this->cell(10,6,$c[6],1,0,($key < 4 ? 'L':'R'),1);
			$this->cell(15,6,$c[7],1,0,($key < 4 ? 'L':'R'),1);
			$this->cell(20,6,$c[8],1,0,($key < 4 ? 'L':'R'),1);
			$this->cell(15,6,$c[9],1,0,($key < 4 ? 'L':'R'),1);
			$this->cell(20,6,$c[10],1,0,($key < 4 ? 'L':'R'),1);
			$this->cell(20,6,$c[11],1,0,($key < 4 ? 'L':'R'),1);
			$this->cell(20,6,$c[12],1,1,($key < 4 ? 'L':'R'),1);
		}
		
	}
	
	private function _header()
	{
		$this->setFillColor(255,204,153);
		$this->cell($col['A'],$row[1],'',1,0,'L',true);
		
	}
	
	
}