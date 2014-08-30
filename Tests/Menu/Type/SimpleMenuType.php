<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Tests\Menu\Type;

use Hw\BasicsBundle\Menu\AbstractMenuType;
use Hw\BasicsBundle\Menu\MenuInterface;
use Hw\BasicsBundle\Menu\MenuItem;


/**
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.29
 */
class SimpleMenuType extends AbstractMenuType
{

	const NAME = 'test';

	/**
	 * Adds menu items to the menu.
	 *
	 * @param MenuInterface $menu
	 */
	public function build(MenuInterface $menu)
	{
		$menu->add('item1', new MenuItem('Label 1'))
			->add('item2', new MenuItem('Label 2'));
	}

	/**
	 * Returns the name for the menu.
	 *
	 * @return string
	 */
	public function getName()
	{
		return self::NAME;
	}

}
