<?php
namespace JLM\TransmitterBundle\Pdf;

use JLM\PdfBundle\Builder\PdfBuilder;

abstract class CourrierBuilder extends PdfBuilder implements CourrierBuilderInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function buildHeader()
	{
		$this->_pdf->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-header-comp.jpg',10,4,190);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildFooter()
	{
		$this->_pdf->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-footer.jpg',50,280,110);
	}
}