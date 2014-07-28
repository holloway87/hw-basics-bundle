<?php

namespace Hw\BasicsBundle\Menu;


/**
 * Abstract menu type to build a menu.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
abstract class AbstractMenuType implements MenuTypeInterface
{

	/**
	 * {@inheritdoc}
	 */
	abstract public function build(MenuInterface $menu);

	/**
	 * {@inheritdoc}
	 */
	abstract public function getName();

}
