<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Twig;

use Hw\BasicsBundle\Breadcrumb\BreadcrumbInterface;
use Hw\BasicsBundle\Breadcrumb\Breadcrumbs;
use Hw\BasicsBundle\Menu\MenuItem;
use Hw\BasicsBundle\Menu\MenuInterface;


/**
 * Provides methods to add menus and breadcrumbs.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
class LayoutService
{

	/**
	 * Breadcrumbs object with all Breadcrumbs.
	 *
	 * @var Breadcrumbs
	 */
	private $breadcrumbs;

	/**
	 * Holds all menus with their keys.
	 *
	 * @var MenuInterface[]
	 */
	private $menus;


	public function __construct()
	{
		$this->breadcrumbs = new Breadcrumbs();
	}

	/**
	 * Returns the menu for the given key if it exists, otherwise null.
	 *
	 * @since 2014.08.06
	 * @param string $key
	 * @return MenuInterface|null
	 */
	private function _getMenu($key)
	{
		$keys = explode('.', $key);
		if (empty($keys))
		{
			return null;
		}

		if (!isset($this->menus[$keys[0]]))
		{
			return null;
		}
		$menu = $this->menus[$keys[0]];
		for ($k = 1; $k < count($keys); $k++)
		{
			$menu = $menu->get($keys[$k]);
			if (is_null($menu))
			{
				return null;
			}
		}
		return $menu;
	}

	/**
	 * Adds a new Menu object with a key.
	 *
	 * Overrides the Menu if the key already exists.
	 *
	 * @param string $key
	 * @param MenuInterface $menu
	 * @return $this
	 */
	public function addMenu($key, MenuInterface $menu)
	{
		$this->menus[$key] = $menu;
		return $this;
	}

	/**
	 * Adds a new Breadcrumb object with a key.
	 *
	 * @param BreadcrumbInterface $breadcrumb
	 * @return $this
	 */
	public function addBreadcrumb(BreadcrumbInterface $breadcrumb)
	{
		$this->breadcrumbs->add($breadcrumb);
		return $this;
	}

	/**
	 * Returns all breadcrumb items.
	 *
	 * @return BreadcrumbInterface[]
	 */
	public function getBreadcrumbs()
	{
		return $this->breadcrumbs->getItems();
	}

	/**
	 * Returns if the menu exists.
	 *
	 * Can be dot separated to get sub menus.
	 *
	 * @since 2014.08.06
	 * @param $key
	 * @return bool
	 */
	public function existsMenu($key)
	{
		$menu = $this->_getMenu($key);
		return is_null($menu) ? false : true;
	}

	/**
	 * Returns the menu item for the given key.
	 *
	 * Can be dot separated to get items from submenus.
	 *
	 * @param $key
	 * @return MenuItem|null
	 */
	public function getMenuItem($key)
	{
		$lastDot = strrpos($key, '.');
		if (false === $lastDot)
		{
			return null;
		}
		$menuKey = substr($key, 0, $lastDot);
		$menu = $this->_getMenu($menuKey);
		if (is_null($menu))
		{
			return null;
		}
		$itemKey = substr($key, $lastDot +1);
		return $menu->get($itemKey);
	}

	/**
	 * Returns all menu items for the given menu key.
	 *
	 * Can be dot separated to get submenus.
	 *
	 * @since 2014.08.06 Using _getMenu() method to get submenus.
	 * @param string $key
	 * @return MenuItem[]|null
	 */
	public function getMenuItems($key)
	{
		$menu = $this->_getMenu($key);
		if (is_null($menu))
		{
			return null;
		}
		return $menu->getItems();
	}

	/**
	 * Sets the item in a menu as active.
	 *
	 * @param string $menuKey
	 * @param string $itemKey
	 * @return $this
	 */
	public function setMenuItemActive($menuKey, $itemKey)
	{
		$menu = $this->_getMenu($menuKey);
		if (is_null($menu))
		{
			return $this;
		}
		$menu->setActiveItem($itemKey);
		return $this;
	}

}
