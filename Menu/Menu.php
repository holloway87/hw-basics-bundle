<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Menu;


/**
 * Put MenuItem objects into one Menu and set the active item.
 *
 * Has Methods to add and remove menu items, check for existence, to clear and to get all items.
 *
 * @see MenuItem
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.06 Extends from AbstractMenuBasic and implements isMenu method, setActive renamed to setActiveItem.
 * @since 2014.07.27
 */
class Menu extends AbstractMenuBasic implements MenuInterface
{

	/**
	 * Key with the active menu item.
	 *
	 * @var string
	 */
	private $activeItem;

	/**
	 * All menu items.
	 *
	 * @var MenuItem[]
	 */
	private $items;


	/**
	 * Sets an empty items array.
	 *
	 * @since 2014.08.06 Call parent constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->clear();
	}

	/**
	 * Sets the given active state recursively to all parent menus.
	 *
	 * @since 2014.08.06
	 * @param bool $active
	 */
	private function _setMenuActiveRecursively($active)
	{
		$menu = $this;
		while (!is_null($menu->getParentMenu()))
		{
			$menu->setActive($active);
			$menu = $menu->getParentMenu();
		}
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 2014.08.06 Sets the parent menu on the item.
	 */
	public function add($key, MenuBasicInterface $item)
	{
		$this->items[$key] = $item;
		$item->setParentMenu($this);
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function clear()
	{
		$this->items = array();
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function exists($key)
	{
		if (isset($this->items[$key]))
		{
			return true;
		}
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($key)
	{
		if (!isset($this->items[$key]))
		{
			return null;
		}
		return $this->items[$key];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isMenu()
	{
		return true;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 2014.08.06 Removes the parent information from the item.
	 */
	public function remove($key)
	{
		if (isset($this->items[$key]))
		{
			$this->items[$key]->setParentMenu(null);
			unset($this->items[$key]);
		}
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setActiveItem($key)
	{
		if (!isset($this->items[$key]))
		{
			return $this;
		}

		// deactivate old entry
		if ($this->activeItem)
		{
			$this->_setMenuActiveRecursively(false);
			$this->items[$this->activeItem]->setActive(false);
		}

		$this->_setMenuActiveRecursively(true);
		$this->items[$key]->setActive(true);
		$this->activeItem = $key;

		return $this;
	}

}
