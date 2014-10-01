<?php
	
class template {
	private $__filename;
// 	private $__properties = array();
	
	public function __construct($filename) {
		$this->__filename = $filename;
	}
	
	public function render() {
		$filename = __DIR__ . '/../templates/' . $this->__filename;
		if(file_exists($filename)) {
			echo translate_block::render(@file_get_contents($filename));
		}
	}
}

class translate_block {
	
	function render($context) {
		var_dump($context);
	}
}

?>
