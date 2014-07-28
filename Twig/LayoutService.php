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
	 * @param string $key
	 * @param BreadcrumbInterface $breadcrumb
	 * @return $this
	 */
	public function addBreadcrumb($key, BreadcrumbInterface $breadcrumb)
	{
		$this->breadcrumbs->add($key, $breadcrumb);
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
	 * Returns all menu items for the given menu key.
	 *
	 * @param string $key
	 * @return MenuItem[]|null
	 */
	public function getMenuItems($key)
	{
		if (!isset($this->menus[$key]))
		{
			return null;
		}
		return $this->menus[$key]->getItems();
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
		if (!isset($this->menus[$menuKey]))
		{
			return $this;
		}
		$this->menus[$menuKey]->setActive($itemKey);
		return $this;
	}

}
