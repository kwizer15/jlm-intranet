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
	public function getPdf()
	{
		return $this->_pdf->output('','S');
	}
}