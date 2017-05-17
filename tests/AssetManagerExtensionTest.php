<?php

namespace ShineUnited\Silex\Assets\Tests;

use ShineUnited\Silex\Assets\AssetManager;
use ShineUnited\Silex\Assets\AssetManagerExtension;
use ShineUnited\Silex\Assets\AssetManagerServiceProvider;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\WebTestCase;


class AssetManagerExtensionTest extends WebTestCase {

	public function createApplication() {
		$app = new Application();

		$app->register(new TwigServiceProvider());

		$app->register(new AssetManagerServiceProvider(), [
			'assets.path' => '/path/to/assets/'
		]);

		$app->match('/', function() use ($app) {
			return $app['twig']->render('test');
		});

		return $app;
	}

	/**
	 *	@dataProvider	assetTestProvider
	 */
	public function testAssetDirect($path, $expect) {
		$code = '{{ asset(\'' . $path . '\') }}';

		$this->app['twig.templates'] = [
			'test' => $code
		];

		$this->app->boot(); // app must be booted

		$actual = $this->app['twig']->render('test');
		$this->assertEquals($expect, $actual);
	}

	/**
	 *	@dataProvider	assetTestProvider
	 */
	public function testAssetSilex($path, $expect) {
		$code = '{{ asset(\'' . $path . '\') }}';

		$this->app['twig.templates'] = [
			'test' => $code
		];

		$client = $this->createClient();
		$crawler = $client->request('GET', '/');

		$actual = $client->getResponse()->getContent();
		$this->assertEquals($expect, $actual);
	}

	public function assetTestProvider() {
		return [
			['my/test/file.txt', '/path/to/assets/my/test/file.txt'],
			['another/file.txt', '/path/to/assets/another/file.txt'],
			['myimage.jpg', '/path/to/assets/myimage.jpg'],
			['img/myimage.jpg', '/path/to/assets/img/myimage.jpg'],
			['js/myjslibrary.js', '/path/to/assets/js/myjslibrary.js'],
		];
	}
}
