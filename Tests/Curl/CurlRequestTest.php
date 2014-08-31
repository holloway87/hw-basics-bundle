<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Tests\Curl;

use Hw\BasicsBundle\Curl\Curl;
use Hw\BasicsBundle\Curl\CurlRequest;


/**
 * Tests for Curl classes.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.31
 */
class CurlRequestTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Tests that the header is returned.
	 */
	public function testCurlHeaderRequest()
	{
		$curlData = new Curl('https://www.google.com/');
		$response = CurlRequest::getHeader($curlData);
		$pos = strpos($response->getResponse(), 'HTTP/1.1 200 OK');
		$this->assertNotFalse($pos);
	}

}
