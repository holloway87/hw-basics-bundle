<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Tests\Util;

use Hw\BasicsBundle\Util\VarAtPath;


/**
 * Test for the VarAtPath utility.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.31
 */
class VarAtPathTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Check for correct values.
	 */
	public function testVarAtPath()
	{
		$object = new TestObject();

		$this->assertEquals(
			'AssociatedTestObject:privateStaticProperty',
			VarAtPath::get($object, 'publicProperty.getPrivateStaticProperty.test')
		);

		$this->assertEquals(
			'TestObject:privateProperty:testKey',
			VarAtPath::get($object, 'getPrivateProperty.testKey')
		);

		$this->assertEquals(
			'TestObject:$publicStaticProperty',
			VarAtPath::get($object, 'publicStaticProperty')
		);

		$this->assertEquals(
			'stringKey',
			VarAtPath::get($object, 'getPrivateProperty.0')
		);

		$this->assertEquals(
			'integerKey',
			VarAtPath::get($object, 'getPrivateProperty.1')
		);
	}

	/**
	 * Checks to throw an exception if the property is not public.
	 *
	 * @expectedException \BadMethodCallException
	 */
	public function testObjectPropertyNotPublicException()
	{
		$object = new TestObject();

		VarAtPath::get($object, 'protectedProperty');
	}

	/**
	 * Checks to throw an exception if the property or method doesn't exist.
	 *
	 * @expectedException \BadMethodCallException
	 */
	public function testObjectNotExistingException()
	{
		$object = new TestObject();

		VarAtPath::get($object, 'nonExistingPropertyOrMethod');
	}

	/**
	 * Checks to throw an exception if the method is not public.
	 *
	 * @expectedException \BadMethodCallException
	 */
	public function testObjectNotPublicMethodException()
	{
		$object = new TestObject();

		VarAtPath::get($object, 'publicProperty.privateMethod');
	}

	/**
	 * Checks to throw an exception if the method has a mandatory parameter.
	 *
	 * @expectedException \BadMethodCallException
	 */
	public function testObjectMethodWithParametersException()
	{
		$object = new TestObject();

		VarAtPath::get($object, 'methodWithParameters');
	}

	/**
	 * Checks to throw an exception if the array key doesn't exist.
	 *
	 * @expectedException \OutOfBoundsException
	 */
	public function testArrayInvalidKeyException()
	{
		$object = new TestObject();

		VarAtPath::get($object, 'getPrivateProperty.invalidKey');
	}

}


class TestObject
{
	public $publicProperty;
	protected $protectedProperty = 'WillThrowException';
	public static $publicStaticProperty = 'TestObject:$publicStaticProperty';
	private $privateProperty = array(
		'testKey' => 'TestObject:privateProperty:testKey',
		'0' => 'stringKey',
		1 => 'integerKey'
	);

	public function __construct()
	{
		$this->publicProperty = new AssociatedTestObject();
	}

	public function getPrivateProperty()
	{
		return $this->privateProperty;
	}

	public function methodWithParameters($mandatory) {}
}

class AssociatedTestObject
{
	private static $privateStaticProperty = array(
		'test' => 'AssociatedTestObject:privateStaticProperty'
	);

	public static function getPrivateStaticProperty()
	{
		return self::$privateStaticProperty;
	}

	private function privateMethod() {}
}
