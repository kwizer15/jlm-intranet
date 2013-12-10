<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Model\ContactInterface;

class PurchaserException extends \Exception {}

/**
 * Customer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Purchaser extends ContactExtension implements ContactInterface
{

}