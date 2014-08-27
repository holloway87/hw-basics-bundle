<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * Compiler pass to get all menu type service definitions.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.08.27
 */
class MenuTypeCompilerPass implements CompilerPassInterface
{

	/**
	 * Looks for menu type service definitions.
	 *
	 * @param ContainerBuilder $container
	 * @api
	 */
	public function process(ContainerBuilder $container)
	{
		$builderId = 'hw_basics.menu.typeextension';
		if (!$container->hasDefinition($builderId))
		{
			return;
		}

		$builder = $container->getDefinition($builderId);

		$services = $container->findTaggedServiceIds('menu.type');
		$typeIds = array();
		foreach ($services as $serviceId => $tag)
		{
			$alias = isset($tag[0]['alias']) ? $tag[0]['alias'] : $serviceId;
			$typeIds[$alias] = $serviceId;
		}
		$builder->replaceArgument(1, $typeIds);
	}

}
