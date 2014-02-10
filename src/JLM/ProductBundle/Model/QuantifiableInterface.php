<?php
namespace JLM\ProductBundle\Model;

interface QuantifiableInterface extends PurchasableInterface, SalableInterface
{
	/**
	 * Get coef
	 * 
	 * @return float
	 */
	public function getCoef();
	
	/**
	 * Get Expense ratio
	 * 
	 * @return float
	 */
	public function getExpenseRatio();
	
	/**
	 * Get Margin
	 * 
	 * @return decimal
	 */
	public function getMargin();
}