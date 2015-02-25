<?php

/*
 * This file is part of the JLMFollowBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FollowBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface StarterInterface
{
	/**
	 * @return string
	 */
	public function getName();
	
	/**
	 * @return BayInterface
	 */
	public function getBusiness();
	
	/**
	 * @return string
	 */
	public function getAmount();
	
	/**
	 * @return string
	 */
	public function getType();
}