<?php
/*
 * Copyright © 2014 Thomas Rudolph <me@holloway-web.de>
 * This work is free. You can redistribute it and/or modify it under the
 * terms of the Do What The Fuck You Want To Public License, Version 2,
 * as published by Sam Hocevar. See the LICENSE file for more details.
 */

namespace Hw\BasicsBundle\Composer;

use Composer\Composer;
use Composer\Installer\InstallationManager;
use Composer\Installer\LibraryInstaller;
use Composer\Package\CompletePackage;
use Composer\Package\Link;
use Composer\Package\RootPackage;
use Composer\Repository\InstalledFilesystemRepository;
use Composer\Repository\RepositoryManager;
use Composer\Script\CommandEvent;
use Symfony\Component\Filesystem\Filesystem;


/**
 * Do stuff when installing or updating composer packages.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.30
 */
class ScriptHandler
{

	/**
	 * Twitter Bootstrap package key for composer.
	 *
	 * @var string
	 */
	private static $bootstrapPackageKey = 'twitter/bootstrap';


	/**
	 * Returns the installed path for the twitter package.
	 *
	 * Or null if not found or not installed.
	 *
	 * @param Composer $composer
	 * @return null|string
	 */
	private static function _getPackagePath(Composer $composer)
	{
		/** @var RepositoryManager $repositoryManager */
		$repositoryManager = $composer->getRepositoryManager();
		/** @var InstalledFilesystemRepository $repository */
		$repository = $repositoryManager->getLocalRepository();
		/** @var InstallationManager $installManager */
		$installManager = $composer->getInstallationManager();

		/** @var CompletePackage[] $packages */
		$packages = $repository->findPackages(self::$bootstrapPackageKey, null);

		foreach ($packages as $package)
		{
			/** @var LibraryInstaller $installer */
			$installer = $installManager->getInstaller($package->getType());
			if ($installer->isInstalled($repository, $package))
			{
				return $installer->getInstallPath($package);
			}
		}

		return null;
	}

	/**
	 * Checks for the twitter/bootstrap package and copys all necessary files into the specified directory.
	 *
	 * Where the files are copied into must be specified in the extra section in the project's `composer.json`.
	 *
	 * 		"extra": {
	 * 			"bootstrap-public-dir": "src/Acme/MyBundle/Resources/public",
	 * 			...
	 * 		}
	 *
	 * @param CommandEvent $event
	 */
	public static function copyBootstrapFiles(CommandEvent $event)
	{
		/** @var RootPackage $package */
		$package = $event->getComposer()->getPackage();
		/** @var Link[] $requires */
		$requires = $package->getRequires();

		// Show error if package was not found
		if (!in_array(self::$bootstrapPackageKey, array_keys($requires))) {
			echo PHP_EOL."\tError: Could not find the Twitter Bootstrap package \"twitter/bootstrap\".".PHP_EOL.PHP_EOL;
			return;
		}

		$fs = new Filesystem();
		// Check for package path
		$packagePath = static::_getPackagePath($event->getComposer());
		if (is_null($packagePath) or !$fs->exists($packagePath))
		{
			echo PHP_EOL."\tError: The twitter bootstrap package doesn't seem to be installed.".PHP_EOL.PHP_EOL;
			return;
		}
		$bootstrapPath = $packagePath.'/dist/';

		// Check the public path where it should be copied to
		$extra = $package->getExtra();
		if (!isset($extra['bootstrap-public-dir']) or !$fs->exists($extra['bootstrap-public-dir']))
		{
			echo PHP_EOL."\tError: Given bootstrap public directory doesn't exist: ".$extra['bootstrap-public-dir'].
				PHP_EOL.PHP_EOL;
			return;
		}
		$bootstrapPublicPath = $extra['bootstrap-public-dir'];

		echo sprintf('Installing twitter bootstrap files into %s%s', $bootstrapPublicPath, PHP_EOL);
		$files = array(
			'js/bootstrap.js',
			'js/bootstrap.min.js',
			'fonts/glyphicons-halflings-regular.eot',
			'fonts/glyphicons-halflings-regular.svg',
			'fonts/glyphicons-halflings-regular.ttf',
			'fonts/glyphicons-halflings-regular.woff'
		);
		foreach ($files as $file)
		{
			$fs->copy($bootstrapPath.$file, $bootstrapPublicPath.'/'.$file, true);
		}
	}

}
