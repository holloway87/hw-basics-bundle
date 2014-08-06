<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Menu;


/**
 * Abstract class which implements basic methods from MenuBasicInterface for inheritance.
 *
 * Can be used for menu and menu item classes.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.06
 */
abstract class AbstractMenuBasic implements MenuBasicInterface
{

	/**
	 * If the item is active.
	 *
	 * @var boolean
	 */
	protected $active;

	/**
	 * Icon for the item.
	 *
	 * @var string
	 */
	protected $icon;

	/**
	 * Label for the item.
	 *
	 * @var string
	 */
	protected $label;

	/**
	 * Parent menu for the item, if set.
	 *
	 * @var MenuInterface|null
	 */
	protected $parentMenu;


	/**
	 * Set active to false.
	 */
	public function __construct()
	{
		$this->active = false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getActive()
	{
		return $this->active;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIcon()
	{
		return $this->icon;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParentMenu()
	{
		return $this->parentMenu;
	}

	/**
	 * {@inheritdoc}
	 */
	abstract public function isMenu();

	/**
	 * {@inheritdoc}
	 */
	public function setActive($active)
	{
		$this->active = $active;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setIcon($icon)
	{
		$this->icon = $icon;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setLabel($label)
	{
		$this->label = $label;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setParentMenu($menu)
	{
		$this->parentMenu = $menu;
		return $this;
	}

}
