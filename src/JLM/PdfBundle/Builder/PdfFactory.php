<?php
namespace JLM\PdfBundle\Builder\PdfFactory;

use JLM\PdfBundle\Adaptor\FPdfAdaptor;

class PdfFactory
{
	private $adaptor;
	
	public function __construct($adaptor = null)
	{
		$adaptor = 'fpdf';
		$this->adaptor = $adaptor;
	}
	
	/**
	 * Creator
	 * @return \JLM\PdfBundle\Model\PdfInterface
	 */
	public static function create(DocumentInterface $doc)
	{
		return $this->_getAdaptor();
	}

	private function _getAdaptor()
	{
		switch ($adaptor)
		{
			case 'fpdf':
				return new FPdfAdaptor();
			default:
				throw new \Exception('Adaptor "'.$adaptor.'" unexist')
		}
	}
}