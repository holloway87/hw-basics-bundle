<?php

namespace Hw\BasicsBundle\Tests\Controller;

use Hw\BasicsBundle\Controller\BaseController;


/**
 * Test for BaseController
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.29
 */
class BaseControllerTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Checks if the generated password has the correct length.
	 * And another one with passed characters.
	 */
	public function testPasswordGenerator()
	{
		$length = 14;

		// Checks if the generated password has the correct length.
		$password = BaseController::generatePassword($length);
		$this->assertEquals($length, strlen($password));

		// And another one with passed characters.
		$password = BaseController::generatePassword($length, '0th3r');
		$this->assertEquals($length, strlen($password));
	}

}
