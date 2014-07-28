<?php

namespace Hw\BasicsBundle\Breadcrumb;


/**
 * Provides data for a breadcrumb.
 *
 * The data consists of a label and a url.
 * The url is optional.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
class Breadcrumb implements BreadcrumbInterface
{

	/**
	 * Label for the breadcrumb
	 *
	 * @var string
	 */
	private $label;

	/**
	 * Optional url for the breadcrumb
	 *
	 * @var string|null
	 */
	private $url;


	/**
	 * {@inheritdoc}
	 */
	public function __construct($label, $url = null)
	{
		$this->label = $label;
		$this->url = $url;
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
	public function getUrl()
	{
		return $this->url;
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
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

}
