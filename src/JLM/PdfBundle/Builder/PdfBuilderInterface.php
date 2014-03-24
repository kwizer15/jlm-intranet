<?php
namespace JLM\PdfBundle\Builder;

interface PdfBuilderInterface
{
	public function getPdf();
	public function create();
}