<?php

namespace ShineUnited\Silex\Assets;

use ShineUnited\Silex\Assets\AssetManager;
use ShineUnited\Silex\Assets\AssetManagerExtension;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;


class AssetManagerServiceProvider implements ServiceProviderInterface, BootableProviderInterface {

	public function register(Container $app) {
		$app['assets'] = function() use ($app) {
			$manager = new AssetManager($app['assets.path']);

			return $manager;
		};

		if(!isset($app['assets.path'])) {
			$app['assets.path'] = '';
		}
	}

	public function boot(Application $app) {
		// extend twig if present
		if(isset($app['twig'])) {
			$app->extend('twig', function($twig, $app) {
				$twig->addExtension(new AssetManagerExtension($app['assets']));

				return $twig;
			});
		}
	}
}
