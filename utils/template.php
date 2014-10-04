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
	
	public static function render($stack, $context) {
		$code_block = new translate_block($stack);
		$regex = '/\{(\w+)\}(.*)[\t\n\r]\{\/\1\}/ms';
		var_dump($context);
		
// 		var_dump($stack);
	}
}

?>
