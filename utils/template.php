<?php

class template {
	private $__filename;
	private $__properties = array();

	public function __construct($filename) {
		$this->__filename = $filename;
	}

	public function render() {
		$filename = __DIR__ . '/../templates/' . $this->__filename;
		if(file_exists($filename)) {
			echo translate_block::render(array($this->__properties), @file_get_contents($filename));
		}
	}

	public function __set($name, $value) {
		$this->__properties[$name] = $value;
	}

	public function __unset($name) {
		unset($this->__properties[$name]);
	}

	public function &__get($name) {
		if (array_key_exists($name, $this->__properties)) { return $this->__properties[$name]; }
		return $null;
	}

	public function __isset($name) {
		return isset($this->__properties[$name]);
	}
}

class translate_block {
	private $stack;

	private function __construct($stack) {
		$this->stack = $stack;
	}

	public static function render($stack, $content) {
		$code_block = new translate_block($stack);
		$regex = '/\{([^\s}]+)\s*([^\s}]+)\}\s*(.*)[\t\n\r]*\{\/\1\s+\2\}/ms'; //NOTE: might revise this regex
		$callback = array($code_block, 'expand');
		return $code_block->resolve($code_block->find_method(preg_replace_callback($regex, $callback, $content)));
// 		var_dump($context);
// 		var_dump($stack);
	}

	private function resolve($body) {
// 		var_dump($body);
	}

	private function find_method($body) {
		$regex = '/\{([^\s}]+)\s+([^}]+)\}/';
// 		var_Dump($body);
		$callback = array($this, 'exec_method');
		return preg_replace_callback($regex, $callback, $body);
	}

	private function exec_method($match) {;
// 	var_dump($match);
		list(, $method, $params) = $match;
		$method = 'expand_' . $method;
// 		var_Dump($method);
		if($method != __FUNCTION__ && method_exists($this, $method)) {
			return $this->$method($params);
		}
		return null;
	}

	private function expand($match) {
// 		var_dump($match);
		list(, $method, $params, $body) = $match;
// 		var_dump($method, $params);
// 		var_dump($method);
		$method = 'parse_' . $method;
		if($method != __FUNCTION__ && method_exists($this, $method)) {
			return $this->$method($params, $params, $body);
		}
		return null;
	}

	private function parse_if($lv, $rv, $body) {
// 		var_dump($lv, $rv, $body);
// 		if(strlen($rv) > 0 ) {
// 		return self::render($this->stack, $parts[0]);
// 		}
// 		return null;
	}

	private function parse_loop($name, $param, $body) {
		var_Dump($name, $param, $body);
		if($this->get_property($name, $parts)) {

		}
// 		var_dump($name, $param, $body);
// 		return null;
	}

	private function get_property($name, &$value) {
		foreach($this->stack as $part) {

		}
	}
}

?>
