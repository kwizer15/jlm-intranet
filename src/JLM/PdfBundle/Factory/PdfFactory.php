<?php
namespace JLM\PdfBundle\Factory\PdfFactory;

use JLM\PdfBundle\Model\Adaptor\FPdfAdaptor;

class PdfFactory
{
	/**
	 * Singleton construct
	 */
	private function __construct() {}
	
	/**
	 * Singleton clone
	 */
	private function __clone() {}
	
	/**
	 * Creator
	 * @return \JLM\PdfBundle\Model\PdfInterface
	 */
	public static function create()
	{
		return new FPdfAdaptor();
	} 
}