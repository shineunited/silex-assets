<?php

namespace ShineUnited\Silex\Assets\Tests;

use ShineUnited\Silex\Assets\AssetManager;


class AssetManagerTest extends \PHPUnit_Framework_TestCase {
	private $managers;

	public function setUp() {
		$this->createManager('empty');

		$this->createManager('simple', '/assets/');

		$this->createManager('simple2', 'https://subdomain.domain.com/path/to/assets/');

		$this->createManager('cdnjs', '/assets/')
			->map('js/jquery.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js')
			->map('js/jqueryui.js', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js')
		;

		$this->createManager('cdnjs2', '/assets/')
			->map('js/jquery.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js')
			->map('js/jqueryui.js', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js')
			->map('js/{library}.js', 'https://cdnjs.cloudflare.com/ajax/libs/{library}/{library}.min.js')
		;
	}

	public function createManager($name, $prefix = '') {
		return $this->managers[$name] = new AssetManager($prefix);
	}

	public function getManager($name) {
		return $this->managers[$name];
	}

	/**
	 *	@dataProvider	lookupProvider
	 */
	public function testLookup($name, $path, $expect) {
		$manager = $this->getManager($name);

		$actual = $manager->lookup($path);
		$this->assertEquals($expect, $actual);
	}

	public function lookupProvider() {
		return [
			['empty', 'my/test/file.txt', 'my/test/file.txt'],
			['simple', 'my/test/file.txt', '/assets/my/test/file.txt'],
			['simple2', 'my/test/file.txt', 'https://subdomain.domain.com/path/to/assets/my/test/file.txt'],
			['cdnjs', 'my/test/file.txt', '/assets/my/test/file.txt'],
			['cdnjs', 'js/jquery.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'],
			['cdnjs', 'js/jqueryui.js', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'],
			['cdnjs2', 'js/jquery.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'],
			['cdnjs2', 'js/jqueryui.js', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'],
		];
	}
}
