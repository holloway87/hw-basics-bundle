<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Menu;

use Hw\BasicsBundle\Exception\UnexpectedTypeException;
use Hw\BasicsBundle\Twig\LayoutService;


/**
 * Class to create new menus with a menu type and add them to the layout service.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
class MenuFactory
{

	/**
	 * Reference to layout service
	 *
	 * @var LayoutService
	 */
	private $layoutservice;

	/**
	 * Type Extension holding all menu types.
	 *
	 * @since 2014.08.27
	 * @var TypeExtensionInterface
	 */
	private $typeExtension;


	/**
	 * Sets the layout service.
	 *
	 * @since 2014.08.27 Added type extension object
	 * @param LayoutService $layoutService
	 * @param TypeExtensionInterface $typeExtension
	 */
	public function __construct(LayoutService $layoutService, TypeExtensionInterface $typeExtension)
	{
		$this->layoutservice = $layoutService;
		$this->typeExtension = $typeExtension;
	}

	/**
	 * Builds the menu with the given type and adds it into the layout service.
	 *
	 * If no name is specified for the menu a RuntimeException will be thrown.
	 *
	 * @param string|MenuTypeInterface $type
	 * @param MenuInterface $menu
	 * @throws \RuntimeException
	 * @throws \Hw\BasicsBundle\Exception\UnexpectedTypeException
	 * @return MenuInterface
	 */
	public function create($type, MenuInterface $menu)
	{
		if (is_string($type))
		{
			$type = $this->typeExtension->getType($type);
		}
		if (!($type instanceof MenuTypeInterface))
		{
			throw new UnexpectedTypeException($type, 'string or Hw\BasicsBundle\Menu\MenuTypeInterface');
		}

		$type->build($menu);

		$key = $type->getName();
		if (!$key)
		{
			throw new \RuntimeException(sprintf('menu type %s returned no name', $key));
		}
		$menu->setName($type->getName());

		$this->layoutservice->addMenu($key, $menu);
		return $menu;
	}

}
