<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Menu;


/**
 * Interface to get a menu type.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.27
 */
interface TypeExtensionInterface
{

	/**
	 * Returns the menu type for the given name.
	 *
	 * Throws an exception if it's not registered.
	 *
	 * @param string $name
	 * @throws \InvalidArgumentException
	 * @return MenuTypeInterface
	 */
	public function getType($name);

	/**
	 * Checks if the given type exists.
	 *
	 * @param string $name
	 * @return bool
	 */
	public function hasType($name);

}
