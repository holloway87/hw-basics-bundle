<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Tests\Twig;

use Hw\BasicsBundle\Breadcrumb\Breadcrumb;
use Hw\BasicsBundle\Menu\Menu;
use Hw\BasicsBundle\Menu\MenuItem;
use Hw\BasicsBundle\Test\ContainerTestCase;


/**
 * Tests for LayoutService.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.29
 */
class LayoutServiceTest extends ContainerTestCase
{

	/**
	 * Checks for the layout service existence.
	 */
	public function testServiceExistence()
	{
		// Check for the layout service existence.
		$this->assertServiceExistence('hw_basics.layoutservice');
	}

	/**
	 * Checks all service methods.
	 *
	 * * Checks for breadcrumbs count.
	 * * Checks for menu existence.
	 * * Checks for active menu item.
	 *
	 * @depends testServiceExistence
	 */
	public function testServiceMethods()
	{
		static::bootKernel();
		$container = self::$kernel->getContainer();
		$layoutService = $container->get('hw_basics.layoutservice');

		// Checks for breadcrumbs count.
		$layoutService->addBreadcrumb(new Breadcrumb('Label 1'))
			->addBreadcrumb(new Breadcrumb('Label 2'));
		$this->assertCount(2, $layoutService->getBreadcrumbs());

		// Checks for menu existence.
		$menuKey = 'main';
		$item1Key = 'item1';
		$item2Key = 'item2';
		$menu = new Menu();
		$menu->add($item1Key, new MenuItem())
			->add($item2Key, new MenuItem());
		$layoutService->addMenu($menuKey, $menu);
		$this->assertCount(2, $layoutService->getMenuItems($menuKey));

		// Checks for active menu item.
		$layoutService->setMenuItemActive($menuKey, $item1Key);
		$this->assertTrue($menu->get($item1Key)->getActive());
	}

}
