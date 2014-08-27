<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Exception;


/**
 * Exception if another type for a variable was expected.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.27
 */
class UnexpectedTypeException extends \InvalidArgumentException
{

	/**
	 * Calculates the message with the given parameters.
	 *
	 * @param mixed $value
	 * @param string $expectedType
	 */
	public function __construct($value, $expectedType)
	{
		parent::__construct(sprintf(
			'Expected argument of type "%s", "%s" given',
			$expectedType, is_object($value) ? get_class($value) : gettype($value)
		));
	}

}
