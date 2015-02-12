<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Entity;

use JLM\ProductBundle\Entity\ProductDecorator;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 * @ORM\Table(name="jlm_daily_product_workshop")
 * @ORM\Entity()
 */
class ProductWorkshop extends ProductDecorator
{
	
}