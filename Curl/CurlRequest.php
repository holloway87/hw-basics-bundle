<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Curl;


/**
 * Executes curl requests.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.31
 */
class CurlRequest
{

	/**
	 * Checks for curl functions.
	 *
	 * @throws \RuntimeException
	 */
	private static function _checkForCurl()
	{
		if (!function_exists('curl_init'))
		{
			throw new \RuntimeException("curl functions doesn't exist, can't do a request");
		}
	}

	/**
	 * Executes the request and returns the response object.
	 *
	 * @param resource $curl
	 * @param $requestedUrl
	 * @return CurlResponse
	 */
	private static function _execute($curl, $requestedUrl)
	{
		$response = curl_exec($curl);
		$errno = curl_errno($curl);
		$error = curl_error($curl);
		$info = curl_getinfo($curl);

		return new CurlResponse($response, $requestedUrl, $info, $errno, $error);
	}

	/**
	 * Initializes the curl resource.
	 *
	 * Throws RuntimeException if something went wrong.
	 *
	 * @param string $url
	 * @return resource
	 * @throws \RuntimeException
	 */
	private static function _initCurl($url)
	{
		$curl = curl_init($url);

		if (false === $curl)
		{
			throw new \RuntimeException('could not initialize curl');
		}

		return $curl;
	}

	/**
	 * Does a HEAD request.
	 *
	 * In the response is only the header.
	 *
	 * @param Curl $curlData
	 * @return CurlResponse
	 */
	public static function getHeader(Curl $curlData)
	{
		self::_checkForCurl();
		$url = $curlData->compileUrl()->getUrl();
		$curl = self::_initCurl($url);

		$options = array(
			CURLOPT_HEADER => true,
			CURLOPT_NOBODY => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FAILONERROR => false,
			CURLOPT_AUTOREFERER => true,
			CURLOPT_FOLLOWLOCATION => true
		);
		foreach ($curlData->getCurlOptions() as $option => $value)
		{
			$options[$option] = $value;
		}
		curl_setopt_array($curl, $options);

		return self::_execute($curl, $url);
	}

	/**
	 * Does a request.
	 *
	 * In the response is only the response body.
	 *
	 * @param Curl $curlData
	 * @return CurlResponse
	 */
	public static function getResponse(Curl $curlData)
	{
		self::_checkForCurl();
		$url = $curlData->compileUrl()->getUrl();
		$curl = self::_initCurl($url);

		$options = array(
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FAILONERROR => false,
			CURLOPT_AUTOREFERER => true,
			CURLOPT_FOLLOWLOCATION => true
		);
		if ($curlData->getBody())
		{
			$options[CURLOPT_POST] = true;
			$options[CURLOPT_POSTFIELDS] = $curlData->getBody();
		}
		foreach ($curlData->getCurlOptions() as $option => $value)
		{
			$options[$option] = $value;
		}
		curl_setopt_array($curl, $options);

		return self::_execute($curl, $url);
	}

}
