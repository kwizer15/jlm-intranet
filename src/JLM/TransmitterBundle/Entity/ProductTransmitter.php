<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Entity;

use JLM\ProductBundle\Entity\ProductDecorator;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 * @ORM\Table(name="jlm_transmitter_product_transmitter")
 * @ORM\Entity()
 */
class ProductTransmitter extends ProductDecorator
{
    
}
