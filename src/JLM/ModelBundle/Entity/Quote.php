<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Quote
 *
 * @ORM\Table(name="quote")
 * @ORM\Entity
 */
class Quote extends Document
{
	/**
	 * @var string $paymentRules
	 *
	 * @ORM\Column(name="payment_rules", type="string", length=255)
	 */
	private $paymentRules;
	
	/**
	 * @var string $deliveryRules
	 *
	 * @ORM\Column(name="delivery_rules", type="string", length=255)
	 */
	private $deliveryRules;
	
	/**
	 * @var string $customerComments
	 *
	 * @ORM\Column(name="customer_comments", type="text")
	 */
	private $customerComments;
	


    /**
     * Set paymentRules
     *
     * @param string $paymentRules
     */
    public function setPaymentRules($paymentRules)
    {
        $this->paymentRules = $paymentRules;
    }

    /**
     * Get paymentRules
     *
     * @return string 
     */
    public function getPaymentRules()
    {
        return $this->paymentRules;
    }

    /**
     * Set deliveryRules
     *
     * @param string $deliveryRules
     */
    public function setDeliveryRules($deliveryRules)
    {
        $this->deliveryRules = $deliveryRules;
    }

    /**
     * Get deliveryRules
     *
     * @return string 
     */
    public function getDeliveryRules()
    {
        return $this->deliveryRules;
    }

    /**
     * Set customerComments
     *
     * @param text $customerComments
     */
    public function setCustomerComments($customerComments)
    {
        $this->customerComments = $customerComments;
    }

    /**
     * Get customerComments
     *
     * @return text 
     */
    public function getCustomerComments()
    {
        return $this->customerComments;
    }
}