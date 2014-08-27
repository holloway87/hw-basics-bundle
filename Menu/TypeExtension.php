<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Menu;

use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Gets all menu types from the compiler pass and loads one if necessary.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.27
 */
class TypeExtension implements TypeExtensionInterface
{

	/**
	 * Symfony Service Container
	 *
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * Array with all menu type service ids.
	 *
	 * @var string[]
	 */
	private $typeIds;


	/**
	 * Sets the container and the type ids.
	 *
	 * @param ContainerInterface $container
	 * @param array $typeIds
	 */
	public function __construct(ContainerInterface $container, array $typeIds)
	{
		$this->container = $container;
		$this->typeIds = $typeIds;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getType($name)
	{
		if (!isset($this->typeIds[$name]))
		{
			throw new \InvalidArgumentException(sprintf(
				'The type with alias "%s" isn\'t registered.', $name
			));
		}

		return $this->container->get($this->typeIds[$name]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasType($name)
	{
		return isset($this->typeIds[$name]);
	}

}
