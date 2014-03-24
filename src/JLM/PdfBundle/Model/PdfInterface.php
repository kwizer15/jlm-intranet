<?php

namespace JLM\PdfBundle\Model\Pdf;

interface PdfInterface
{
	public function setMargins($left, $top, $right = null);
	public function setLeftMargin($margin);
	public function setTopMargin($margin);
	public function setRightMargin($margin);
	public function setAutoPageBreak($auto, $margin = 0);
	public function setDisplayMode($zoom, $layout = 'default');
	public function setCompression($compress);
	public function setTitle($title);
	public function setSubject($subjecte);
	public function setAuthor($author);
	public function setKeywords($keywords);
	public function setCreator($creator);
	public function aliasNbPages($alias = '{nb}');
	public function error($msg);
	public function open();
	public function close();
	public function addPage($orientation = '', $size = '');
	public function header();
	public function footer();
	public function pageNo();
	public function setDrawColor($r, $g = null, $b = null);
	public function setFillColor($r, $g = null, $b = null);
	public function setTextColor($r, $g = null, $b = null);
	public function setStringWidth($s);
	public function setLineWidth($width);
	public function line($x1, $y1, $x2, $y2);
	public function rect($x, $y, $w, $h, $style = '');
	public function addFont($family, $style = '', $file = '');
	public function setFont($family, $style = '', $size = 0);
	public function setFontSize($size);
	public function addLink();
	public function setLink($link, $y = 0, $page = -1);
	public function link($x, $y, $w, $h, $link);
	public function text($x, $y, $txt);
	public function acceptPageBreak();
	public function cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '');
	public function multiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false);
	public function write($h, $txt, $link = '');
	public function ln($h = null);
	public function image($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '');
	public function getX();
	public function setX($x);
	public function getY();
	public function setY($y);
	public function setXY($x, $y);
	public function output($name = '', $dest = '');
}
						
