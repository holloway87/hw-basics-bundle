<?php

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
