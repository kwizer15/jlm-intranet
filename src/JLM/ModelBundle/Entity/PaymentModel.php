<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\PaymentModel
 *
 * @ORM\Table(name="paymentmodel")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\PaymentModelRepository")
 */
class PaymentModel extends TextModel
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}