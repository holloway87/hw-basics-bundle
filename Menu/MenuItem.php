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
 * To set an active menu item use the method Menu::setActive(), it takes care to only set one item as active.
 *
 * @see Menu::setActive()
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
class MenuItem
{

	/**
	 * If the item is active.
	 *
	 * @var boolean
	 */
	private $active;

	/**
	 * Icon for the item.
	 *
	 * @var string
	 */
	private $icon;

	/**
	 * Label for the item.
	 *
	 * @var string
	 */
	private $label;

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
	 * @param string $label
	 * @param string $url
	 * @param string|null $target
	 */
	public function __construct($label = '', $url = '', $target = null)
	{
		$this->label = $label;
		$this->target = $target;
		$this->url = $url;
	}

	/**
	 * Get if the item is active.
	 *
	 * @return boolean
	 */
	public function getActive()
	{
		return $this->active;
	}

	/**
	 * Get the icon for the item.
	 *
	 * @return string
	 */
	public function getIcon()
	{
		return $this->icon;
	}

	/**
	 * Get the label for the item.
	 *
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * Get the target for the item.
	 *
	 * @return null|string
	 */
	public function getTarget()
	{
		return $this->target;
	}

	/**
	 * Get the url for the item.
	 *
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Set if the item is active.
	 *
	 * @param boolean $active
	 * @return $this
	 */
	public function setActive($active)
	{
		$this->active = $active;
		return $this;
	}

	/**
	 * Set the icon for the item.
	 *
	 * @param string $icon
	 * @return $this
	 */
	public function setIcon($icon)
	{
		$this->icon = $icon;
		return $this;
	}

	/**
	 * Set the label for the item.
	 *
	 * @param string $label
	 * @return $this
	 */
	public function setLabel($label)
	{
		$this->label = $label;
		return $this;
	}

	/**
	 * Set the target for the item.
	 *
	 * @param null|string $target
	 * @return $this
	 */
	public function setTarget($target)
	{
		$this->target = $target;
		return $this;
	}

	/**
	 * Set the url for the item.
	 *
	 * @param string $url
	 * @return $this
	 */
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

}
