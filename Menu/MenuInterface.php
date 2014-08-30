<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Menu;


/**
 * Interface for a menu.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.06 Extends the MenuBasicInterface for hierarchic menus.
 * @since 2014.07.27
 */
interface MenuInterface extends MenuBasicInterface
{

	/**
	 * Adds a new item or menu to the menu with the given key.
	 *
	 * If a key already exists the menu item will be overridden.
	 * This Method should set the parent menu for the item.
	 *
	 * @since 2014.08.06 $item must be instance of MenuBasicInterface to be a menu or a menu item
	 * @param string $key
	 * @param MenuBasicInterface $item
	 * @return $this
	 */
	public function add($key, MenuBasicInterface $item);

	/**
	 * Clears all items.
	 *
	 * @return $this
	 */
	public function clear();

	/**
	 * Checks if the key is set.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function exists($key);

	/**
	 * Returns the menu item for the given key.
	 *
	 * If the key doesn't exist, it returns null.
	 *
	 * @param string $key
	 * @return MenuItemInterface|null
	 */
	public function get($key);

	/**
	 * Returns all menu items.
	 *
	 * @return MenuItemInterface[]
	 */
	public function getItems();

	/**
	 * Returns the name the menu is identified with.
	 *
	 * Will be filled by the menu factory.
	 *
	 * @since 2014.08.30
	 * @return string
	 */
	public function getName();

	/**
	 * Removes the item with the given key.
	 *
	 * @param string $key
	 * @return $this
	 */
	public function remove($key);

	/**
	 * Set the active item with the given key.
	 *
	 * Automaticely deactivates the old active item, if set.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function setActiveItem($key);

	/**
	 * Sets the name the menu is identified with.
	 *
	 * @since 2014.08.30
	 * @param string $name
	 * @return $this
	 */
	public function setName($name);

}
