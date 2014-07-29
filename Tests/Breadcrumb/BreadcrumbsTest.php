<?php

namespace Hw\BasicsBundle\Tests\Breadcrumb;

use Hw\BasicsBundle\Breadcrumb\Breadcrumb;
use Hw\BasicsBundle\Breadcrumb\Breadcrumbs;


/**
 * Test for breadcrumbs.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.29
 */
class BreadcrumbsTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Tests the Breacrumb and Breadcrumbs classes.
	 *
	 * Adds 2 Breadcrumbs and checks for count.
	 * Checks for labels and urls in breadrumb entities.
	 * Clears breadcrumbs and checks for count.
	 */
	public function testBreadcrumbs()
	{
		$label1 = 'Label1';
		$label2 = 'Label2';
		$url = 'http://u.rl/';
		$breadcrumbs = new Breadcrumbs();
		$breadcrumb1 = new Breadcrumb($label1, $url);
		$breadcrumb2 = new Breadcrumb($label2);

		// Adds 2 Breadcrumbs and checks for count.
		$breadcrumbs->add($breadcrumb1)->add($breadcrumb2);
		$this->assertCount(2, $breadcrumbs->getItems());

		// Checks for labels and urls in breadrumb entities.
		$this->assertEquals($label1, $breadcrumb1->getLabel());
		$this->assertEquals($url, $breadcrumb1->getUrl());
		$this->assertEquals($label2, $breadcrumb2->getLabel());
		$this->assertNull($breadcrumb2->getUrl());

		// Clears breadcrumbs and checks for count.
		$breadcrumbs->clear();
		$this->assertCount(0, $breadcrumbs->getItems());
	}

}
