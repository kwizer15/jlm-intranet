<?php
namespace JLM\DefaultBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;

class Tag extends FPDFext
{
	private $entity;
	private $count = 0;

	public static function get($codes)
	{
		$pdf = new self();
		$pdf->_init();
		foreach ($codes as $code)
			$pdf->addEntity(strtoupper($code));
		return $pdf->Output('','S');
	}
	
	public function addEntity($code)
	{
		switch ($this->count)
		{
			case 0:
				$this->addPage('L');
				$this->setMargins(0,0,0,0);
				$this->line(148,0,148,210);
				$this->line(0,105,297,105);
				$origX = 0;
				$origY = 0;
				break;
			case 1:
				$origX = 148;
				$origY = 0;
				break;
			case 2:
				$origX = 0;
				$origY = 105;
				break;
			case 3:
				$origX = 148;
				$origY = 105;
				break;
		}
		$this->image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-logo-comp.jpg',$origX+50,$origY+10,80);
		$url = 'http://chart.apis.google.com/chart?chs=180x180&choe=UTF-8&cht=qr&chl=http://www.jlm-entreprise.fr/installation/'.$code;
		$this->image($url,$origX+8,$origY+8,40,40,'png');
		$this->setXY($origX+10,$origY+50);
		$this->setFont('Arial','B',15);
		$this->multiCell(128,7,'En cas de panne blablabla');
		$this->setXY($origX+98,$origY+70);
		// Numéro d'install
		$this->setFont('Arial','B',22);
		$this->cell(35,10,$code,true,0,'C');
		$this->count = ($this->count == 3) ? 0 : $this->count + 1;
		
		return $this;
	}
	
	public function _init()
	{
		$this->aliasNbPages();
		$this->setFillColor(200);
	}
}