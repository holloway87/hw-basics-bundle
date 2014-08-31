<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Curl;


/**
 * Holds the response data from a curl request.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.31
 */
class CurlResponse
{

	/**
	 * Error code
	 *
	 * @var integer
	 */
	private $errno;

	/**
	 * Error message
	 *
	 * @var string
	 */
	private $error;

	/**
	 * Info about the response.
	 *
	 * @var array
	 */
	private $info;

	/**
	 * The requested url
	 *
	 * @var string
	 */
	private $requestedUrl;

	/**
	 * Response body
	 *
	 * @var string
	 */
	private $response;


	/**
	 * Instantiate the object with all data.
	 *
	 * @param string $response
	 * @param string $requestedUrl
	 * @param array $info
	 * @param integer $errno
	 * @param string $error
	 */
	public function __construct($response, $requestedUrl, $info, $errno, $error)
	{
		$this->errno = $errno;
		$this->error = $error;
		$this->info = $info;
		$this->requestedUrl = $requestedUrl;
		$this->response = $response;
	}

	/**
	 * Returns the curl error code.
	 *
	 * @see http://curl.haxx.se/libcurl/c/libcurl-errors.html
	 * @return int
	 */
	public function getErrno()
	{
		return $this->errno;
	}

	/**
	 * Returns the error message.
	 *
	 * @return string
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * Returns the info about the response.
	 *
	 * @see http://php.net/manual/de/function.curl-getinfo.php
	 * @return array
	 */
	public function getInfo()
	{
		return $this->info;
	}

	/**
	 * Returns the originally requested url.
	 *
	 * Can differ from info['url'] if curl followed redirects.
	 *
	 * @return string
	 */
	public function getRequestedUrl()
	{
		return $this->requestedUrl;
	}

	/**
	 * Returns the response.
	 *
	 * @return string
	 */
	public function getResponse()
	{
		return $this->response;
	}

}
