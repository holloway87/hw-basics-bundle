<?php

namespace Hw\BasicsBundle\Breadcrumb;


/**
 * Interface for breadcrumb entity
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.24
 */
interface BreadcrumbInterface
{

	/**
	 * Sets the label and the url.
	 *
	 * @param string $label
	 * @param null $url
	 */
	public function __construct($label, $url = null);

	/**
	 * Returns the label for the breadcrumb.
	 *
	 * @return string
	 */
	public function getLabel();

	/**
	 * Returns the url for the breadrcumb.
	 *
	 * Null if none is set.
	 *
	 * @return null|string
	 */
	public function getUrl();

	/**
	 * @param string $label
	 * @return $this
	 */
	public function setLabel($label);

	/**
	 * Sets the url for the breadcrumb.
	 *
	 * Set null if there is no url for the breadcrumb.
	 *
	 * @param null|string $url
	 * @return $this
	 */
	public function setUrl($url);

}
