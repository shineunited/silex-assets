<?php

namespace ShineUnited\Silex\Assets;

use ShineUnited\Silex\Assets\AssetPattern;


class AssetManager {
	const HIGH_PRIORITY = 512;
	const LOW_PRIORITY = -512;

	private $patterns = array();
	private $sorted = array();
	private $prefix;

	public function __construct($prefix = '') {
		$this->prefix = $prefix;
	}

	public function map($pattern, $replace, $priority = 0) {
		$this->patterns[$priority][] = new AssetPattern($pattern, $replace);
		$this->sorted = null;

		return $this;
	}

	public function lookup($path) {
		if(count($this->patterns) <= 0) {
			return $this->prefix . $path;
		}

		if(!is_array($this->sorted)) {
			krsort($this->patterns);
			$this->sorted = call_user_func_array('array_merge', $this->patterns);
		}

		foreach($this->sorted as $pattern) {
			if(!$pattern->matches($path)) {
				continue;
			}

			return $pattern->replace($path);
		}

		return $this->prefix . $path;
	}
}
