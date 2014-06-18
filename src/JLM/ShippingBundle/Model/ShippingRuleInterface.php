<?php

interface ShippingRuleInterface
{
	/**
	 * @return decimal
	 */
	public function getAmount(OrderInterface $order);
}