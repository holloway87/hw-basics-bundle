<?php

namespace Hw\BasicsBundle\Menu;


/**
 * Put MenuItem objects into one Menu and set the active item.
 *
 * Has Methods to add and remove menu items, check for existence, to clear and to get all items.
 *
 * @see MenuItem
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
class Menu implements MenuInterface
{

	/**
	 * Key with the active menu item.
	 *
	 * @var string
	 */
	private $activeItem;

	/**
	 * All menu items.
	 *
	 * @var MenuItem[]
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
	public function add($key, MenuItem $item)
	{
		$this->items[$key] = $item;
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
	public function exists($key)
	{
		if (isset($this->items[$key]))
		{
			return true;
		}
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($key)
	{
		if (!isset($this->items[$key]))
		{
			return null;
		}
		return $this->items[$key];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * {@inheritdoc}
	 */
	public function remove($key)
	{
		if (isset($this->items[$key]))
		{
			unset($this->items[$key]);
		}
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setActive($key)
	{
		if (!isset($this->items[$key]))
		{
			return $this;
		}

		// deactivate old entry
		if ($this->activeItem)
		{
			$this->items[$this->activeItem]->setActive(false);
		}

		$this->items[$key]->setActive(true);
		$this->activeItem = $key;

		return $this;
	}

}
