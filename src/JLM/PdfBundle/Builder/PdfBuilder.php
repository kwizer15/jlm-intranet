<?php
namespace JLM\PdfBundle\Builder;

use JLM\PdfBundle\Factory\PdfFactory;

abstract class PdfBuilder implements PdfBuilderInterface
{
	/**
	 * Pdf
	 * @var PdfInterface
	 */
	protected $_pdf;
	
	/**
	 * {@inheritdoc}
	 */
	public function create()
	{
		$this->_pdf = PdfFactory::create();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildHeader()
	{
		$this->_pdf->image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-header-comp.jpg',10,4,190);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildFooter()
	{
		$this->_pdf->image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-footer.jpg',50,280,110);
	}
}