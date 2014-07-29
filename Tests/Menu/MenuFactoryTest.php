<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Tests\Menu;

use Hw\BasicsBundle\Menu\Menu;
use Hw\BasicsBundle\Tests\Menu\Type\ErrorMenuType;
use Hw\BasicsBundle\Tests\Menu\Type\SimpleMenuType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


/**
 * Tests for MenuFactory
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.29
 */
class MenuFactoryTest extends KernelTestCase
{

	/**
	 * Checks for the existence of services.
	 *
	 * * Checks for the factory service existence.
	 * * Checks for the layout service existence.
	 */
	public function testServiceExistence()
	{
		static::bootKernel();
		$container = self::$kernel->getContainer();

		// Checks for the factory service extistence.
		$this->assertTrue($container->has('hw_basics.menufactory'));

		// Checks for the layout service existence.
		$this->assertTrue($container->has('hw_basics.layoutservice'));
	}

	/**
	 * Checks the factory method.
	 *
	 * * Checks if menu was created.
	 * * Checks for item count after factoring.
	 *
	 * @depends testServiceExistence
	 */
	public function testFactory()
	{
		static::bootKernel();
		$container = self::$kernel->getContainer();
		$factory = $container->get('hw_basics.menufactory');

		$factory->create(new SimpleMenuType(), new Menu());
		$items = $container->get('hw_basics.layoutservice')->getMenuItems('test');

		// Checks if menu was created.
		$this->assertNotNull($items);

		// Checks for item count after factoring.
		$this->assertCount(2, $items);
	}

	/**
	 * Checks for Exception when no name is returned from the menu type.
	 *
	 * @expectedException \RuntimeException
	 */
	public function testFactoryException()
	{
		static::bootKernel();
		$container = self::$kernel->getContainer();
		$factory = $container->get('hw_basics.menufactory');

		// Checks for Exception when no name is returned from the menu type.
		$factory->create(new ErrorMenuType(), new Menu());
	}

}
