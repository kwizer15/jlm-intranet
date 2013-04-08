<?php
namespace JLM\DailyBundle\Pdf;

class Tomorrow extends \FPDF
{
	private $entities;
	private $date;
	
	public static function get(\DateTime $date, $entities)
	{
		$pdf = new self();
		$pdf->_init();
		$pdf->_header($date);
		foreach ($entities as $entity)
			$pdf->_show($entity,$date);
		return $pdf->Output('','S');
	}
	
	private function _init()
	{
		$this->aliasNbPages();
		$this->setFillColor(200);
		$this->addPage('L');
	}
	
	private function _header(\DateTime $date)
	{
		$this->setFont('Arial','B',18);
		$this->cell(0,12,'Interventions du '.$date->format('d/m/Y'),1,1,'C',true);
		$this->ln(5);
		$this->setFont('Arial','B',11);
		$this->cell(23,6,'Type',1,0,'L',true);
		$this->cell(77,6,'Affaire',1,0,'L',true);
		$this->cell(8,6,'Ctr',1,0,'L',true);
		$this->cell(109,6,'Raison',1,0,'L',true);
		$this->cell(30,6,'Contact',1,0,'L',true);
		$this->cell(30,6,'Technicien',1,1,'L',true);
		$this->setFont('Arial','',10);
	}
	
	private function _show($entity,$date)
	{
		$types = array(
				'fixing' => 'Dépannage',
				'equipment' => 'Matériel',
				'maintenance' => 'Entretien',
				'work' => 'Travaux',
		);
		$xorig = $this->getX();
		$this->cell(23,5,$types[$entity->getType()],0,0,'L');
		$x = $this->getX();
		$yorig = $this->getY();
		if ($entity->getType() != 'equipment')
		{
			if ($entity->getDoor())
			{
				$this->multicell(77,6,
			
					$entity->getDoor()->getType()
					.' - '
					.$entity->getDoor()->getLocation()
					.chr(10)
					.$entity->getDoor()->getStreet()
					.chr(10)
					.$entity->getDoor()->getSite()->getAddress()->getCity()
					,1,'L');
			}
			else
				$this->multicell(77,5,$entity->getPlace(),0,'L');
		}
		else
			$this->multicell(77,5,$entity->getPlace(),0,'L');
		$ymax = $this->getY();
		$x += 77;
		$this->setXY($x,$yorig);
		if ($entity->getType() != 'equipment')
		{
			if ($entity->getContract() == 'Hors contrat')
				$this->cell(8,5,'HC',0,0,'L');
			else
				$this->cell(8,5,$entity->getContract(),0,0,'L');
		}
		else 
			$this->cell(8,5,'',1,0,'L');
		$x = $this->getX();
		$ymax = max($ymax,$this->getY());
		$this->multicell(109,5,$entity->getReason(),0,'L');
		$x += 109;
		$this->setXY($x,$yorig);
		if ($entity->getType() != 'equipment')
		{
			$this->cell(30,5,$entity->getContactName(),0,2,'L');
			$this->multicell(30,5,$entity->getContactPhones(),0,'L');
		}
		
		$ymax = max($ymax,$this->getY());
		$x += 30;
		$this->setXY($x,$yorig);
		foreach($entity->getShiftTechnicians() as $tech)
		{
			if ($tech->getBegin() == $date)
				$this->cell(30,5,$tech->getTechnician(),0,2,'L');
		}
		$ymax = max($ymax,$this->getY());
		$this->setXY($xorig,$yorig);
		$ysize = $ymax - $yorig;
		$this->cell(23,$ysize,'',1,0);
		$this->cell(77,$ysize,'',1,0);
		$this->cell(8,$ysize,'',1,0);
		$this->cell(109,$ysize,'',1,0);
		$this->cell(30,$ysize,'',1,0);
		$this->cell(30,$ysize,'',1,1);	
	}
	
	public function cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
	{
		return parent::cell($w,$h,utf8_decode($txt),$border,$ln,$align,$fill,$link);
	}
}