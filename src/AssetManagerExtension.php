<?php

namespace ShineUnited\Silex\Assets;

use ShineUnited\Silex\Assets\AssetManager;


class AssetManagerExtension extends \Twig_Extension {
	private $manager;

	public function __construct(AssetManager $manager) {
		$this->manager = $manager;
	}

	public function getFunctions() {
		return array(
			new \Twig_SimpleFunction('asset', array($this->manager, 'lookup'))
		);
	}

	public function getName() {
		return 'assets';
	}
}
