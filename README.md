Holloway's Basics Bundle
========================

This Symfony Bundle includes some basic layout and controller functionality.


Installation
------------

### Use Composer (*recommended*)

The easiest way to install this bundle is via composer.  Just add it to the require list in the symfony project's
`composer.json`.

	"holloway87/hw-basics-bundle": "dev-master"

### Download an archive

You can download an archive on the repository's [github page][1].  Extract the archive into your `src/` folder into
the directory `Hw/BasicsBundle`.


Features
--------

These are some features this bundle gives you:

 * Create menus with items via a menu type class (similar to form types from symfony)
 * Use your menus in twig layouts with a global function
 * Create Breadcrumbs and access them in your twig layouts with a global function
 * A base controller class exists to easily encode an entity's password or generate a random one
 * Copy twitter bootstrap files to your resource directory on composer update or install
 * A utility class to manipulate images with the gd library (cut a rectangle, resize, black & white filter, ...)
 * Classes exist to easily execute a curl request and access the response data


Feature plans
-------------

I will add more features and wiki pages how to use the bundle.

[1]: https://github.com/holloway87/hw-basics-bundle
