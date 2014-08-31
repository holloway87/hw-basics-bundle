<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Controller;

use Hw\BasicsBundle\Menu\MenuInterface;
use Hw\BasicsBundle\Menu\MenuTypeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Base controller which provides useful methods.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
class BaseController extends Controller
{

	/**
	 * Returns the encoded password which can be set in an entity.
	 *
	 * To encode the password the SecurityBundle has to be activated.
	 * The given entity must at least implement the UserInterface.
	 *
	 * @see Symfony\Bundle\SecurityBundle\SecurityBundle
	 * @param UserInterface $entity
	 * @return string
	 */
	protected function _encodePassword(UserInterface $entity)
	{
		$factory = $this->get('security.encoder_factory');
		/** @var \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface $encoder */
		$encoder = $factory->getEncoder($entity);
		return $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
	}

	/**
	 * Creates a new menu with the given type.
	 *
	 * Per default it uses the Menu class from the HwBasicsBundle.
	 *
	 * @param MenuTypeInterface|string $type
	 * @param string|null $activeItem
	 * @return MenuInterface
	 */
	public function createMenu($type, $activeItem = null)
	{
		$menuClass = $this->container->getParameter('hw_basics.menu.class');
		$menu = $this->get('hw_basics.menufactory')->create($type, new $menuClass());
		if (!is_null($activeItem))
		{
			$menu->setActiveItem($activeItem);
		}
		return $menu;
	}

	/**
	 * Creates a random password from a set of characters.
	 *
	 * With the optional $chars parameter you can specify the characters to choose from.
	 *
	 * @param int $length
	 * @param string|null $chars
	 * @return string
	 */
	public static function generatePassword($length = 8, $chars = null)
	{
		if (!$chars)
		{
			$chars = 'abcdefghijklmnoqrstuvwxyz-_ABCDEFGHIJKLMNOQRSTUVWXYZ0123456789';
		}
		$charsCnt = strlen($chars);
		$password = '';
		for($i = 0; $i < $length; $i++)
		{
			$char = $chars[rand(0, $charsCnt - 1)];
			$password .= $char;
		}
		return $password;
	}

	/**
	 * Returns if the user is logged in.
	 *
	 * If the security context service is not available it returns false.
	 *
	 * @since 2014.08.31
	 * @return boolean
	 */
	public function isLoggedIn()
	{
		if ($this->has('security.context'))
		{
			return false;
		}

		return $this->get('security.context')
			->isGranted('IS_AUTHENTICATED_FULLY')
			? true : false;
	}

}
