<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Tests\Controller;

use Hw\BasicsBundle\Controller\BaseController;
use Hw\BasicsBundle\Test\ContainerTestCase;
use Hw\BasicsBundle\Tests\Menu\Type\SimpleMenuType;


/**
 * Test for BaseController
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.29
 */
class BaseControllerTest extends ContainerTestCase
{

	/**
	 * Checks the generatorPassword Method
	 *
	 * * Checks if the generated password has the correct length.
	 * * And another one with passed characters.
	 */
	public function testPasswordGenerator()
	{
		$length = 14;

		// Checks if the generated password has the correct length.
		$password = BaseController::generatePassword($length);
		$this->assertEquals($length, strlen($password));

		// And another one with passed characters.
		$password = BaseController::generatePassword($length, '0th3r');
		$this->assertEquals($length, strlen($password));
	}

	/**
	 * Checks the create menu method.
	 *
	 * * Check for menu factory service existance.
	 * * Check if correct item is set as active via controller method.
	 *
	 * @since 2014.08.29
	 */
	public function testCreateMenu()
	{
		// Check for menu factory service existance.
		$this->assertServiceExistence('hw_basics.menufactory');

		// Prepare controller.
		$controller = new BaseController();
		$controller->setContainer($this->getContainer());

		// Check if correct item is set as active via controller method.
		$menu = $controller->createMenu(new SimpleMenuType(), 'item1');
		$this->assertTrue($menu->get('item1')->getActive());
	}

}
