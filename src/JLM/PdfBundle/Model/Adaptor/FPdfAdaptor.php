<?php
namespace JLM\PdfBundle\Model\Adaptor;

use JLM\PdfBundle\Model\Pdf\PdfInterface;

class FPdfAdaptor implements PdfInterface
{
	private $pdf;
	
	public function __construct($orientation='P', $unit='mm', $size='A4')
	{
		$this->pdf = new FPDF($orientation, $unit, $size); 
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setMargins($left, $top, $right = null)
	{
		$this->pdf->SetMargins($left, $top, $right);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setLeftMargin($margin)
	{
		$this->pdf->SetLeftMargin($margin);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setTopMargin($margin)
	{
		$this->pdf->SetTopMargin($margin);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setRightMargin($margin)
	{
		$this->pdf->SetRightMargin($margin);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setAutoPageBreak($auto, $margin = 0)
	{
		$this->pdf->SetAutoPageBreak($auto, $margin);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setDisplayMode($zoom, $layout = 'default')
	{
		$this->pdf->SetDisplayMode($zoom, $layout);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setCompression($compress)
	{
		$this->pdf->SetCompression($compress);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setTitle($title)
	{
		$this->pdf->SetTitle($title, true);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setSubject($subject)
	{
		$this->pdf->SetSubject($subject, true);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setAuthor($author)
	{
		$this->pdf->SetAuthor($author, true);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setKeywords($keywords)
	{
		$this->pdf->SetKeywords($keywords, true);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setCreator($creator)
	{
		$this->pdf->SetCreator($creator, true);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function aliasNbPages($alias = '{nb}')
	{
		$this->pdf->AliasNbPages($alias);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function error($msg)
	{
		$this->pdf->Error($msg);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function open()
	{
		$this->pdf->Open();
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function close()
	{
		$this->pdf->Close();
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function addPage($orientation = '', $size = '')
	{
		$this->pdf->AddPage($orientation, $size);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function header()
	{
		$this->pdf->Header();
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function footer()
	{
		$this->pdf->Footer();
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function pageNo()
	{
		return $this->pdf->PageNo();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setDrawColor($r, $g = null, $b = null)
	{
		$this->pdf->SetDrawColor($r, $g, $b);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setFillColor($r, $g = null, $b = null)
	{
		$this->pdf->SetFillColor($r, $g, $b);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setTextColor($r, $g = null, $b = null)
	{
		$this->pdf->SetTextColot($r, $g, $b);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setStringWidth($s)
	{
		$this->pdf->SetStringWidth($s);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setLineWidth($width)
	{
		$this->pdf->SetLineWidth($width);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function line($x1, $y1, $x2, $y2)
	{
		$this->pdf->Line($x1, $y1, $x2, $y2);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rect($x, $y, $w, $h, $style = '')
	{
		$this->pdf->Rect($x, $y, $w, $h, $style);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function addFont($family, $style = '', $file = '')
	{
		$this->pdf->AddFont($family, $style, $file);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setFont($family, $style = '', $size = 0)
	{
		$this->pdf->SetFont($family, $style, $size);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setFontSize($size)
	{
		$this->pdf->SetFontSize($size);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function addLink()
	{
		return $this->pdf->AddLink();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setLink($link, $y = 0, $page = -1)
	{
		$this->pdf->SetLink($link, $y, $page);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function link($x, $y, $w, $h, $link)
	{
		$this->pdf->Link($x, $y, $w, $h, $link);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function text($x, $y, $txt)
	{
		$this->pdf->Text($x, $y, $txt);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function acceptPageBreak()
	{
		return $this->pdf->AcceptPageBreak();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
	{
		$this->pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function multiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false)
	{
		$this->pdf->MultiCell($w, $h, $txt, $border, $align, $fill);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function write($h, $txt, $link = '')
	{
		$this->pdf->Write($h, $txt, $link);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function ln($h = null)
	{
		$this->pdf->Ln($h);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function image($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '')
	{
		$this->pdf->Image($file, $x, $y, $w, $h, $type, $link);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getX()
	{
		return $this->pdf->GetX();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setX($x)
	{
		$this->pdf->SetX($x);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getY()
	{
		return $this->pdf->GetY();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setY($y)
	{
		$this->pdf->SetY($y);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setXY($x, $y)
	{
		$this->pdf->SetXY($x, $y);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function output($name = '', $dest = '')
	{
		return $this->pdf->Output($name, $dest);
	}
}