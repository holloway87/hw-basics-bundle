<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Util;


/**
 * Receives a variable from a dotted path from a given array or object.
 *
 * Use static method get().
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.31
 */
class VarAtPath
{

	/**
	 * Holds the actual path.
	 *
	 * @var string
	 */
	private static $actPath;

	/**
	 * Holds the act path part.
	 *
	 * @var string
	 */
	private static $part;

	/**
	 * Holds the actual reference along the path.
	 *
	 * @var mixed
	 */
	private static $reference;


	/**
	 * Proceeds into an array key.
	 *
	 * Throws an exception if the key doesn't exist.
	 *
	 * @throws \OutOfBoundsException
	 */
	private static function _processArray()
	{
		if (!isset(self::$reference[self::$part]))
		{
			throw new \OutOfBoundsException(sprintf('Invalid array key %s at path "%s"', self::$part, self::$actPath));
		}
		self::$reference = self::$reference[self::$part];
	}

	/**
	 * Proceeds into an object with a property access or method call.
	 */
	private static function _processObject()
	{
		$reflector = new \ReflectionObject(self::$reference);
		$previousException = null;
		// first check for public property
		try
		{
			self::_processObjectProperty($reflector);
			return;
		}
		catch (\OutOfBoundsException $e)
		{
			$previousException = $e;
		}
		// now check for method call
		try
		{
			self::_processObjectMethod($reflector);
		}
		catch (\BadMethodCallException $e)
		{
			throw new \BadMethodCallException($e->getMessage(), $e->getCode(), $previousException);
		}
	}

	/**
	 * Checks to call the method.
	 *
	 * Throws exceptions if the method doesn't exist, is not public or if there are mandatory parameters.
	 *
	 * @param \ReflectionObject $reflector
	 * @throws \BadMethodCallException
	 */
	private static function _processObjectMethod(\ReflectionObject $reflector)
	{
		// check for method name
		if (!$reflector->hasMethod(self::$part))
		{
			throw new \BadMethodCallException(sprintf(
				'Method %s doesn\'t exist at path "%s"', self::$part, self::$actPath
			));
		}

		// check that method is public
		$methodReclector = $reflector->getMethod(self::$part);
		if (!$methodReclector->isPublic())
		{
			throw new \BadMethodCallException(sprintf(
				'Method %s is not public at path "%s"', self::$part, self::$actPath
			));
		}

		// check that method has no mandatory parameters
		$parameters = $methodReclector->getParameters();
		if (!empty($parameters))
		{
			foreach ($parameters as $parameter)
			{
				// If has no default value, throw exception, can't call the method without parameters
				try
				{
					$parameter->getDefaultValue();
				}
				catch (\ReflectionException $e)
				{
					throw new \BadMethodCallException(sprintf(
						'Method %s has mandatory parameter at path "%s", can\'t call it', self::$part, self::$actPath
					));
				}
			}
		}

		$method = self::$part;
		self::$reference = self::$reference->$method();
	}

	/**
	 * Checks to access the property.
	 *
	 * Throws exceptions if the property doesn't exist or is not public.
	 *
	 * @param \ReflectionObject $reflector
	 * @throws \OutOfBoundsException
	 */
	private static function _processObjectProperty(\ReflectionObject $reflector)
	{
		if (!$reflector->hasProperty(self::$part))
		{
			throw new \OutOfBoundsException(sprintf(
				'Property %s doesn\'t exist at path "%s"', self::$part, self::$actPath
			));
		}

		// check that property is public
		$propertyReflector = $reflector->getProperty(self::$part);
		if (!$propertyReflector->isPublic())
		{
			throw new \OutOfBoundsException(sprintf(
				'Property %s is not public at path "%s"', self::$part, self::$actPath
			));
		}

		self::$reference = $propertyReflector->getValue(self::$reference);
	}

	/**
	 * Receives the variable from the dotted path.
	 *
	 * On an array it uses the index, on an object it tries either to access a public property or call a method with no
	 * mandatory parameters.
	 *
	 * @param array|object $var
	 * @param string $path
	 * @return mixed
	 */
	public static function get($var, $path)
	{
		if (!(is_array($var) or is_object($var)))
		{
			return $var;
		}

		$parts = explode('.', $path);
		self::$reference = $var;

		self::$actPath = '';
		foreach ($parts as self::$part)
		{
			// check array key
			if (is_array(self::$reference))
			{
				self::_processArray();
			}
			// check object
			elseif (is_object(self::$reference))
			{
				self::_processObject();
			}
			self::$actPath .= (self::$actPath ? '.': '').self::$part;
		}

		return self::$reference;
	}

}
