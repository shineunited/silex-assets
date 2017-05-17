<?php

namespace ShineUnited\Silex\Assets\Tests;

use ShineUnited\Silex\Assets\AssetManager;
use ShineUnited\Silex\Assets\AssetManagerServiceProvider;

use Silex\Application;
use Silex\WebTestCase;


class AssetManagerServiceProviderTest extends WebTestCase {

	public function createApplication() {
		$app = new Application();

		$app->register(new AssetManagerServiceProvider());

		return $app;
	}

	public function testBeforeBoot() {
		$this->assertInstanceOf(AssetManager::class, $this->app['assets']);
	}

	public function testAfterBoot() {
		$this->app->boot();

		$this->assertInstanceOf(AssetManager::class, $this->app['assets']);
	}
}
