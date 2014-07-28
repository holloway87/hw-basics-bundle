<?php

namespace Hw\BasicsBundle\Menu;

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
	 * Sets the layout service.
	 *
	 * @param LayoutService $layoutService
	 */
	public function __construct(LayoutService $layoutService)
	{
		$this->layoutservice = $layoutService;
	}

	/**
	 * Builds the menu with the given type and adds it into the layout service.
	 *
	 * If no name is specified for the menu a RuntimeException will be thrown.
	 *
	 * @param MenuTypeInterface $type
	 * @param MenuInterface $menu
	 * @return MenuInterface
	 * @throws \RuntimeException
	 */
	public function create(MenuTypeInterface $type, MenuInterface $menu)
	{
		$type->build($menu);

		$key = $type->getName();
		if (!$key)
		{
			throw new \RuntimeException(sprintf('menu type %s returned no name', $key));
		}

		$this->layoutservice->addMenu($key, $menu);
		return $menu;
	}

}
