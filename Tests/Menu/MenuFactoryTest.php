<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Tests\Menu;

use Hw\BasicsBundle\Menu\Menu;
use Hw\BasicsBundle\Test\ContainerTestCase;
use Hw\BasicsBundle\Tests\Menu\Type\ErrorMenuType;
use Hw\BasicsBundle\Tests\Menu\Type\SimpleMenuType;


/**
 * Tests for MenuFactory
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.29
 */
class MenuFactoryTest extends ContainerTestCase
{

	/**
	 * Checks for the existence of services.
	 *
	 * * Checks for the factory service existence.
	 * * Checks for the layout service existence.
	 */
	public function testServiceExistence()
	{
		// Checks for the factory service extistence.
		$this->assertServiceExistence('hw_basics.menufactory');

		// Checks for the layout service existence.
		$this->assertServiceExistence('hw_basics.layoutservice');
	}

	/**
	 * Checks the factory method.
	 *
	 * * Checks if menu was created.
	 * * Checks for item count after factoring.
	 * * Check that factory sets menu name.
	 *
	 * @depends testServiceExistence
	 * @since 2014.08.30 Added check that factory sets menu name.
	 */
	public function testFactory()
	{
		$container = $this->getContainer();
		$factory = $container->get('hw_basics.menufactory');

		$menu = $factory->create(new SimpleMenuType(), new Menu());
		$items = $container->get('hw_basics.layoutservice')->getMenuItems('test');

		// Checks if menu was created.
		$this->assertNotNull($items);

		// Checks for item count after factoring.
		$this->assertCount(2, $items);

		// Check that factory sets menu name.
		$this->assertEquals(SimpleMenuType::NAME, $menu->getName());
	}

	/**
	 * Checks for Exception when no name is returned from the menu type.
	 *
	 * @since 2014.08.06 Added depencency from testServiceExistence
	 * @depends testServiceExistence
	 * @expectedException \RuntimeException
	 */
	public function testFactoryException()
	{
		$factory = $this->getContainer()->get('hw_basics.menufactory');

		// Checks for Exception when no name is returned from the menu type.
		$factory->create(new ErrorMenuType(), new Menu());
	}

	/**
	 * Checks for Exception when type name is not registered.
	 *
	 * @since 2014.08.27
	 * @depends testServiceExistence
	 * @expectedException \InvalidArgumentException
	 */
	public function testFactoryWrongTypeException()
	{
		$factory = $this->getContainer()->get('hw_basics.menufactory');

		// Checks for Exception when type name is not registered.
		$factory->create('nonexisting.menu.type', new Menu());
	}

}
