<?php

namespace JLM\UserBundle\Repository;

use JLM\UserBundle\Entity\User;

interface UserRepositoryInterface
{
	/**
	 * 
	 * @param User $user
	 * @return mixed
	 */
	public function getByUser(User $user);
}