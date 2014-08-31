<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Curl;


/**
 * Curl object to do a request with.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.31
 */
class Curl
{

	/**
	 * Base url for the request, without any parameters.
	 *
	 * @var string
	 */
	private $baseUrl;

	/**
	 * Body for the request.
	 *
	 * @var array|string
	 */
	private $body;

	/**
	 * Array with curl options.
	 *
	 * @var array
	 */
	private $curlOptions;

	/**
	 * Get parameters for url.
	 *
	 * @var array
	 */
	private $parameters;

	/**
	 * Compiled url with optional get parameters.
	 *
	 * @var string
	 */
	private $url;


	/**
	 * Sets default values.
	 *
	 * * Optionally set the correct base url
	 * * Empty array for get parameters
	 */
	public function __construct($baseUrl = null)
	{
		$this->baseUrl = $baseUrl;
		$this->curlOptions = array();
		$this->parameters = array();
	}

	/**
	 * Compiles the url.
	 *
	 * Adds get parameters if specified.
	 *
	 * @return $this
	 */
	public function compileUrl()
	{
		if (empty($this->parameters))
		{
			$this->url = $this->baseUrl;
			return $this;
		}

		$parameters = array();
		foreach ($this->parameters as $key => $value)
		{
			if (!is_string($key))
			{
				continue;
			}
			$parameters[] = sprintf('%s=%s', $key, urlencode($value));
		}

		$this->url = sprintf('%s?%s', $this->baseUrl, implode('&', $parameters));
		return $this;
	}

	/**
	 * Returns the base url.
	 *
	 * @return string
	 */
	public function getBaseUrl()
	{
		return $this->baseUrl;
	}

	/**
	 * Returns the body for the request.
	 *
	 * @return array|string
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * Returns all curl options.
	 *
	 * @return array
	 */
	public function getCurlOptions()
	{
		return $this->curlOptions;
	}

	/**
	 * Returns all parameters for the url.
	 *
	 * @return array
	 */
	public function getParameters()
	{
		return $this->parameters;
	}

	/**
	 * Returns the compiled url.
	 *
	 * If the url wasn't compiled yet it will be.  If you edit the base url or parameters you have to call the
	 * compileUrl() method manually again.
	 *
	 * @see Curl::compileUrl()
	 * @return string
	 */
	public function getUrl()
	{
		if (is_null($this->url))
		{
			$this->compileUrl();
		}
		return $this->url;
	}

	/**
	 * Sets the base url.
	 *
	 * @param string $baseUrl
	 * @return $this
	 */
	public function setBaseUrl($baseUrl)
	{
		$this->baseUrl = $baseUrl;
		return $this;
	}

	/**
	 * Sets the body for the request.
	 *
	 * @param array|string $body
	 * @return $this
	 */
	public function setBody($body)
	{
		$this->body = $body;
		return $this;
	}

	/**
	 * Sets a curl option.
	 *
	 * @param integer $key
	 * @param mixed $value
	 * @return $this
	 */
	public function setCurlOption($key, $value)
	{
		$this->curlOptions[$key] = $value;
		return $this;
	}

	/**
	 * Sets all curl options.
	 *
	 * @param array $curlOptions
	 * @return $this
	 */
	public function setCurlOptions(array $curlOptions)
	{
		$this->curlOptions = $curlOptions;
		return $this;
	}

	/**
	 * Sets one parameter for the url.
	 *
	 * @param string $key
	 * @param string $value
	 * @return $this
	 */
	public function setParameter($key, $value)
	{
		$this->parameters[$key] = $value;
		return $this;
	}

	/**
	 * Sets all parameters for the url.
	 *
	 * @param array $parameters
	 * @return $this
	 */
	public function setParameters(array $parameters)
	{
		$this->parameters = $parameters;
		return $this;
	}

}
