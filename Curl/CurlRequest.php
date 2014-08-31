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
	 * Whether to follow redirects or not
	 *
	 * @var bool
	 */
	private static $follow;

	/**
	 * Maximum times for manually following redirects
	 *
	 * @var int
	 */
	private static $maxRedirects;


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
	 * @throws \RuntimeException
	 * @return CurlResponse
	 */
	private static function _execute($curl, $requestedUrl)
	{
		$response = curl_exec($curl);
		$errno = curl_errno($curl);
		$error = curl_error($curl);
		$info = curl_getinfo($curl);

		// Workaround to follow redirects in old php version (Screw them)
		$version = explode('.', phpversion());
		$version = intval($version[0].$version[1]);
		if (54 > $version and self::$follow and 0 < self::$maxRedirects)
		{
			if (!isset($info['redirect_url']))
			{
				throw new \RuntimeException('no redirect url in curl info');
			}
			if (preg_match('#^https?://#i', $info['redirect_url']))
			{
				self::$maxRedirects--;
				curl_setopt($curl, CURLOPT_URL, $info['redirect_url']);
				return self::_execute($curl, $requestedUrl);
			}
		}

		curl_close($curl);
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
	 * Appends all options set by the curl data object and then set them to the curl resource.
	 *
	 * Oh, and a dirty hack to apply following redirects to php < 5.4
	 *
	 * @param resource $curl
	 * @param array $options
	 * @param Curl $curlData
	 */
	public static function _setCurlOptions($curl, array $options, Curl $curlData)
	{
		$version = explode('.', phpversion());
		$version = intval($version[0].$version[1]);
		foreach ($curlData->getCurlOptions() as $option => $value)
		{
			if (54 > $version and CURLOPT_FOLLOWLOCATION == $option)
			{
				if (!$value)
				{
					self::$follow = false;
				}
			}
			$options[$option] = $value;
		}
		if (54 > $version and self::$follow)
		{
			$options[CURLOPT_FOLLOWLOCATION] = false;
			self::$follow = true;
			self::$maxRedirects = 10;
		}
		curl_setopt_array($curl, $options);
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

		self::$follow = true;
		$options = array(
			CURLOPT_HEADER => true,
			CURLOPT_NOBODY => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FAILONERROR => false,
			CURLOPT_AUTOREFERER => true,
			CURLOPT_FOLLOWLOCATION => true
		);
		self::_setCurlOptions($curl, $options, $curlData);

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

		self::$follow = true;
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
		self::_setCurlOptions($curl, $options, $curlData);

		return self::_execute($curl, $url);
	}

}
