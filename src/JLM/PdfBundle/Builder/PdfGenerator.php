<?php
namespace JLM\PdfBundle\Builder;

use JLM\PdfBundle\Builder\PdfBuilderInterface;

class PdfGenerator
{
	private $builder;
	
	public function __construct(PdfBuilderInterface $builder)
	{
		$this->builder = $builder;
	}
	
	public function build()
	{
		$this->builder->buildContent();
		
		return $this;
	}
	
	public function getPdf()
	{
		return $this->builder->getPdf();
	}
}