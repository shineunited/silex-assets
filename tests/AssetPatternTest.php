<?php

namespace ShineUnited\Silex\Assets\Tests;

use ShineUnited\Silex\Assets\AssetPattern;


class AssetPatternTest extends \PHPUnit_Framework_TestCase {

	/**
	 *	@dataProvider	matchesProvider
	 */
	public function testMatches($pattern, $subject, $expect) {
		$assetPattern = new AssetPattern($pattern, $pattern);

		$actual = $assetPattern->matches($subject);
		$this->assertEquals($expect, $actual);
	}

	public function matchesProvider() {
		return [
			['path/to/{dir}/{file}.xls', 'path/to/mydir/myfile.xls', true],
			['path/to/{dir}/{file}.xls', 'mydir/myfile.xls', false],
			['{file}', 'my/test/file.txt', true],
		];
	}

	/**
	 *	@dataProvider	replaceProvider
	 */
	public function testReplace($pattern, $replace, $subject, $expect) {
		$assetPattern = new AssetPattern($pattern, $replace);

		$actual = $assetPattern->replace($subject);
		$this->assertEquals($expect, $actual);
	}

	public function replaceProvider() {
		return [
			['path/to/{dir}/{file}.xls', '/assets/path/to/{dir}/{file}.xls', 'path/to/mydir/myfile.xls', '/assets/path/to/mydir/myfile.xls'],
			['path/to/{dir}/{file}.xls', '/assets/path/to/{dir}/{file}.xls', 'mydir/myfile.xls', 'mydir/myfile.xls'],
			['{file}', '/assets/{file}', 'my/test/file.txt', '/assets/my/test/file.txt'],
		];
	}
}
