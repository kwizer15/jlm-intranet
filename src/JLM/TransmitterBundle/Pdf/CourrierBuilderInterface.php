<?php
namespace JLM\TransmitterBundle\Pdf;

use JLM\PdfBundle\Builder\PdfBuilderInterface;

interface CourrierBuilderInterface extends PdfBuilderInterface
{
	public function buildHeader();
	public function buildFooter();
}