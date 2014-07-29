<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


/**
 * Provides methods to assert for services and to easily get the container.
 *
 * Every method boots the kernel without options if it wasn't booted yet.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.29
 */
class ContainerTestCase extends KernelTestCase
{

	/**
	 * Checks if the kernel isn't instanced or the container isn't present and boots the kernel.
	 */
	private function _checkContainer()
	{
		if (is_null(self::$kernel) or is_null(self::$kernel->getContainer()))
		{
			static::bootKernel();
		}
	}

	/**
	 * Checks for a service existence.
	 *
	 * If the kernel wasn't booted yet, it will be (without any options).
	 *
	 * @param string $serviceId
	 */
	protected function assertServiceExistence($serviceId)
	{
		$this->_checkContainer();
		$this->assertTrue(self::$kernel->getContainer()->has($serviceId));
	}

	/**
	 * Returns the Symfony Container.
	 *
	 * If the kernel wasn't booted yet, it will be (without any options).
	 *
	 * @return \Symfony\Component\DependencyInjection\ContainerInterface
	 */
	protected function getContainer()
	{
		$this->_checkContainer();
		return self::$kernel->getContainer();
	}

}
