<?php

namespace ShineUnited\Silex\Assets;

use ShineUnited\Silex\Assets\AssetManager;
use ShineUnited\Silex\Assets\AssetManagerExtension;

use Silex\Application;
use Silex\ServiceProviderInterface;


class AssetManagerServiceProvider implements ServiceProviderInterface {

	public function register(Application $app) {
		$app['assets'] = $app->share(function() use ($app) {
			$manager = new AssetManager($app['assets.path']);

			return $manager;
		});

		if(!isset($app['assets.path'])) {
			$app['assets.path'] = '';
		}
	}

	public function boot(Application $app) {
		// extend twig if present
		if(isset($app['twig'])) {
			$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
				$twig->addExtension(new AssetManagerExtension($app['assets']));

				return $twig;
			}));
		}
	}
}
