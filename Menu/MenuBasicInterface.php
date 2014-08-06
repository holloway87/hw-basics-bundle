<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Menu;


/**
 * Interface for basic menu and menu item methods.
 *
 * Can be used for items and menus as well.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.06
 */
interface MenuBasicInterface
{

	/**
	 * Returns if the item is set as active.
	 *
	 * @return bool
	 */
	public function getActive();

	/**
	 * Returns the icon for the item.
	 *
	 * @return string
	 */
	public function getIcon();

	/**
	 * Returns the label.
	 *
	 * @return string
	 */
	public function getLabel();

	/**
	 * Returns the parent menu, if set.
	 *
	 * @return MenuInterface|null
	 */
	public function getParentMenu();

	/**
	 * Returns if the object is a menu or a menu item.
	 *
	 * True for menu, false for item.
	 *
	 * @return bool
	 */
	public function isMenu();

	/**
	 * Sets if the item is active.
	 *
	 * @param bool $active
	 * @return $this
	 */
	public function setActive($active);

	/**
	 * Sets the icon for the item.
	 *
	 * @param $icon
	 * @return $this
	 */
	public function setIcon($icon);

	/**
	 * Sets the label.
	 *
	 * @param string $label
	 * @return $this
	 */
	public function setLabel($label);

	/**
	 * Sets the parent menu for the item.
	 *
	 * Null represents the base level.
	 *
	 * @param MenuInterface|null $menu
	 * @return $this
	 */
	public function setParentMenu($menu);

}
