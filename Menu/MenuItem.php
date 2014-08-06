<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Menu;


/**
 * Provides data for a menu item.
 *
 * The data consists of the label, the url for the item and if it active at the moment.
 * Furthermore you can set a string for an icon (css class or filename for example) and the target string
 * (target attribute for &lt;a&gt;).
 *
 * To set an active menu item use the method Menu::setActiveItem(), it takes care to only set one item as active.
 *
 * @see Menu::setActiveItem()
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.06 Extends from AbstractMenuBasic and implements isMenu method.
 * @since 2014.07.27
 */
class MenuItem extends AbstractMenuBasic implements MenuItemInterface
{

	/**
	 * Target for the item.
	 *
	 * @var string|null
	 */
	private $target;

	/**
	 * Url for the item.
	 *
	 * @var string
	 */
	private $url;


	/**
	 * Can optionally set the label, url and target for the item with the constructor.
	 *
	 * @since 2014.08.06 Call parent constructor.
	 * @param string $label
	 * @param string $url
	 * @param string|null $target
	 */
	public function __construct($label = '', $url = '', $target = null)
	{
		parent::__construct();
		$this->label = $label;
		$this->target = $target;
		$this->url = $url;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTarget()
	{
		return $this->target;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isMenu()
	{
		return false;
	}

	/**
	 * {@inheritdoc}
	 * @return $this
	 */
	public function setTarget($target)
	{
		$this->target = $target;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return $this
	 */
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

}
