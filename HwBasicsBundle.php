<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle;

use Hw\BasicsBundle\DependencyInjection\Compiler\MenuTypeCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;


/**
 * Holloway's Basics Bundle
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 */
class HwBasicsBundle extends Bundle
{

	/**
	 * Adds the menu type compiler pass.
	 *
	 * @since 2014.08.27
	 * @param ContainerBuilder $container
	 */
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		$container->addCompilerPass(new MenuTypeCompilerPass());
	}

}
