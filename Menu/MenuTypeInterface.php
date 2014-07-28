<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Menu;


/**
 * Interface for menu type to build a menu.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
interface MenuTypeInterface
{

	/**
	 * Adds menu items to the menu.
	 *
	 * @param MenuInterface $menu
	 */
	public function build(MenuInterface $menu);

	/**
	 * Returns the name for the menu.
	 *
	 * @return string
	 */
	public function getName();

}
