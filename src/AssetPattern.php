<?php

namespace ShineUnited\Silex\Assets;


class AssetPattern {
	private $pattern;
	private $replace;

	public function __construct($pattern, $replace) {
		if(preg_match_all('/{(\w+)}/', $pattern, $matches)) {
			$patternPattern = array();
			$patternReplace = array();
			$replacePattern = array();
			$replaceReplace = array();
			$variableCount = 1;
			foreach($matches[1] as $match) {
				$patternPattern[] = '/\{' . $match . '\}/';
				$patternReplace[] = '(.*)';

				$replacePattern[] = '/\{' . $match . '\}/';
				$replaceReplace[] = '\\\\' . $variableCount++;
			}


			$pattern = preg_replace($patternPattern, $patternReplace, $pattern);
			$replace = preg_replace($replacePattern, $replaceReplace, $replace);
		}

		$this->pattern = '@^' . $pattern . '$@';
		$this->replace = $replace;
	}

	public function matches($path) {
		return preg_match($this->pattern, $path);
	}

	public function replace($path) {
		return preg_replace($this->pattern, $this->replace, $path);
	}
}
