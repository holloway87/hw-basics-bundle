<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Tests\Menu;

use Hw\BasicsBundle\Menu\Menu;
use Hw\BasicsBundle\Menu\MenuItem;


/**
 * Tests for menus.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.29
 */
class MenuTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Tests for Menu and MenuItem classes.
	 *
	 * * Check for menu items count.
	 * * Check for item values.
	 * * Check if object is menu or not.
	 * * Check active status on items.
	 * * Check for item existence.
	 * * Check existence after removing item.
	 * * Check item count after clearing menu items.
	 * * Check for menu parent after add and after remove.
	 *
	 * @since 2014.08.06 Added test for parent menu, more tests for active status and if object is menu.
	 */
	public function testMenu()
	{
		$label1 = 'Label1';
		$label2 = 'Label2';
		$url = '/url';
		$icon = 'icon';
		$target = 'target';
		$menu = new Menu();
		$item1 = new MenuItem($label1, $url);
		$item2 = new MenuItem($label2);
		$item1->setIcon($icon)->setTarget($target);

		// Check for menu items count.
		$menu->add('item1', $item1)->add('item2', $item2);
		$this->assertCount(2, $menu->getItems());

		// Check for item values.
		$this->assertEquals($label1, $menu->get('item1')->getLabel());
		$this->assertEquals($label2, $menu->get('item2')->getLabel());
		$this->assertEquals($url, $menu->get('item1')->getUrl());
		$this->assertEquals('', $menu->get('item2')->getUrl());
		$this->assertEquals($icon, $menu->get('item1')->getIcon());
		$this->assertNull($menu->get('item2')->getIcon());
		$this->assertEquals($target, $menu->get('item1')->getTarget());
		$this->assertNull($menu->get('item2')->getTarget());

		// Check if object is menu or not.
		$this->assertTrue($menu->isMenu());
		$this->assertFalse($item1->isMenu());

		// Check active status on items.
		$menu->setActiveItem('item1');
		$this->assertTrue($menu->get('item1')->getActive());
		$menu->setActiveItem('item2');
		$this->assertFalse($menu->get('item1')->getActive());
		$submenu = new Menu();
		$submenu->add('subitem', new MenuItem());
		$menu->add('submenu', $submenu);
		$submenu->setActiveItem('subitem');
		$this->assertTrue($submenu->getActive());
		$this->assertNotTrue($menu->getActive());

		// Check for item existence.
		$this->assertTrue($menu->exists('item1'));
		$this->assertFalse($menu->exists('item3'));

		// Check existence after removing item.
		$menu->remove('item2');
		$this->assertFalse($menu->exists('item2'));

		// Check item count after clearing menu items.
		$menu->clear();
		$this->assertCount(0, $menu->getItems());

		// Check for menu parent after add and after remove.
		$menu->add('item1', $item1);
		$this->assertEquals($menu, $item1->getParentMenu());
		$menu->remove('item1');
		$this->assertNull($item1->getParentMenu());
	}

}
