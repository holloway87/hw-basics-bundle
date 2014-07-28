<?php

namespace Hw\BasicsBundle\Twig;
use Hw\BasicsBundle\Breadcrumb\Breadcrumbs;
use Hw\BasicsBundle\Menu\MenuItem;


/**
 * Twig extension to get the menus and breadcrumbs in templates.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
class HwBasicsExtension extends \Twig_Extension
{

	/**
	 * Reference to the layout service.
	 *
	 * @var LayoutService
	 */
	private $layoutService;


	/**
	 * Sets the layout service.
	 *
	 * @param LayoutService $layoutService
	 */
	public function __construct(LayoutService $layoutService)
	{
		$this->layoutService = $layoutService;
	}

	/**
	 * Returns all functions to use in templates.
	 *
	 * @return array
	 */
	public function getFunctions()
	{
		return array(
			new \Twig_SimpleFunction('layoutmenu', array($this, 'getMenu')),
			new \Twig_SimpleFunction('breadcrumbs', array($this, 'getBreadcrumbs'))
		);
	}

	public function getBreadcrumbs()
	{
		return $this->layoutService->getBreadcrumbs();
	}

	/**
	 * Returns the name of the extension.
	 *
	 * @return string
	 */
	public function getName()
	{
		return 'hw_basics_extension';
	}

	/**
	 * Returns all menu items for the given menu key.
	 *
	 * @param string $key
	 * @return MenuItem[]|null
	 */
	public function getMenu($key)
	{
		return $this->layoutService->getMenuItems($key);
	}

}
