<?php
namespace JLM\PdfBundle\Builder;

interface PdfBuilderInterface
{
	/**
	 * Create the empty Pdf
	 */
	public function create();
	
	/**
	 * Build the content
	 */
	public function buildContent();
	
	/**
	 * Return Pdf as string
	 *
	 * @return string
	 */
	public function getPdf();
}