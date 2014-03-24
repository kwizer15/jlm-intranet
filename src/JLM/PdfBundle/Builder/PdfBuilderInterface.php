<?php
namespace JLM\PdfBundle\Builder;

interface PdfBuilderInterface
{
	/**
	 * Return Pdf as string
	 * 
	 * @return string
	 */
	public function getPdf();
	
	/**
	 * Create the empty Pdf
	 */
	public function create();
	
	/**
	 * Build the content
	 */
	public function buildContent();
}