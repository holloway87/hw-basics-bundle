<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Menu;


/**
 * Interface for menu item methods.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.06
 */
interface MenuItemInterface extends MenuBasicInterface
{

	/**
	 * Returns the target for the item.
	 *
	 * @return null|string
	 */
	public function getTarget();

	/**
	 * Returns the url for the item.
	 *
	 * @return string
	 */
	public function getUrl();

	/**
	 * Sets the target for the item.
	 *
	 * @param null|string $target
	 * @return $this
	 */
	public function setTarget($target);

	/**
	 * Sets the url for the item.
	 *
	 * @param string $url
	 * @return $this
	 */
	public function setUrl($url);

}
