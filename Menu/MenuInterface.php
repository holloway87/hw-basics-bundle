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
 * @since 2014.07.27
 */
interface MenuInterface
{

	/**
	 * Adds a new item to the menu with the given key.
	 *
	 * If a key already exists the menu item will be overridden.
	 *
	 * @param string $key
	 * @param MenuItem $item
	 * @return $this
	 */
	public function add($key, MenuItem $item);

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
	 * The key should be a string, but scalar variables will be converted into a string.
	 *
	 * @param string $key
	 * @return MenuItem|null
	 */
	public function get($key);

	/**
	 * Returns all menu items.
	 *
	 * @return MenuItem[]
	 */
	public function getItems();

	/**
	 * Removes the item with the given key.
	 *
	 * The key should be a string, but scalar variables will be converted into a string.
	 *
	 * @param string $key
	 * @return $this
	 */
	public function remove($key);

	/**
	 * Set the active item with the given key.
	 *
	 * Automaticely deactivates the old active item, if set.
	 * The key should be a string, but scalar variables will be converted into a string.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function setActive($key);

}
