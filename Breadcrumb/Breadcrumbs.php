<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Breadcrumb;


/**
 * Add Breadcrumb objects.
 *
 * Has Methods to add breadcrumbs, to clear and to get all items.
 *
 * @see BreadcrumbInterface
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
class Breadcrumbs
{

	/**
	 * All breadcrumb items.
	 *
	 * @var BreadcrumbInterface[]
	 */
	private $items;


	/**
	 * Sets an empty items array.
	 */
	public function __construct()
	{
		$this->clear();
	}

	/**
	 * {@inheritdoc}
	 */
	public function add(BreadcrumbInterface $item)
	{
		$this->items[] = $item;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function clear()
	{
		$this->items = array();
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getItems()
	{
		return $this->items;
	}

}
