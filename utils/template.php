<?php

//TODO: add a single encapsulated variable translation. {content} => "This is a content";

class template {
	private $__filename;
	private $__properties = array();

	public function __construct($filename) {
		$this->__filename = $filename;
	}

	public function render() {
		$filename = __DIR__ . '/../templates/' . $this->__filename;
		if(file_exists($filename)) {
			echo translate_block::render($this->__properties, @file_get_contents($filename));
		} else {
			throw new Exception($this->__filename . ' does not exist');
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
		$arranged_data = $code_block->arrange_code($content);
		$resolved_data = $code_block->resolve($arranged_data, $stack);
		$content = $code_block->replace_contents($content, $resolved_data);
		return $content;
	}

	private function resolve($data_companent, $stack) {
		foreach($data_companent as $operation => $companent) {
			switch($operation) {
				case "loop":
					$data_companent[$operation .' '. $companent->variable] = $this->parse_loop($companent->html, empty($stack[$companent->variable])?"": $stack[$companent->variable]);
				break;
				case "if":
					$data_companent[$operation .' '. $companent->variable] = $this->parse_if($companent->html, empty($stack[$companent->variable]) ? "": $stack[$companent->variable]);
				break;
			}
			unset($data_companent[$operation]);
		}
		return $data_companent;
	}

	private function arrange_code($content) {
		$arranged_data = array();
		//TODO: revise the regex to allow nested loops and complex if statements
		$regex = '/\{([^\s}]+)\s*([^\s}]+)\}\s*(.*)[\t\n\r]*\{\/\1\s+\2\}/ms';
		if(preg_match_all($regex, $content, $match)) {
			# $match[1] - op
			# $match[2] - var
			# $match[3] - content (might have more elements to parse)
			foreach($match[1] as $index => $operation) {
				$arranged_data[$operation] = (object) array("variable" => $match[2][$index],
															"html" => trim($match[3][$index]));
			}
			return $arranged_data;
		}
		return $content;
	}

	private function parse_loop($html, $replacements) {
		if(empty($replacements)) {
			return (preg_replace('/\{([^\s]*?)\}/','',$html));
		}
		$replaced_html = "";
		if(preg_match_all('/\{([^\s]*?)\}/', $html, $match)) {
			# $match[1] - var
			foreach($replacements as $replacement) {
				foreach($match[1] as $index => $var) {
					$html = preg_replace('/\{'.$var.'\}/',$replacement[$match[1][$index]],  $html);
				}
				$replaced_html .= trim($html);
			}
			return $replaced_html;
		}
	}

	private function parse_if($html, $replacements) {
		if(empty($replacements)) {
			return (preg_replace('/\{([^\s]*?)\}/','',$html));
		}
		preg_match('/\{([^\s]*?)\}/', $html, $match);
		# $match[1] - var
		$html = preg_replace('/\{([^\s]*?)\}/',isset($replacements[$match[1]])?$replacements[$match[1]]:'', $html);
		return $html;
	}

	private function replace_contents($content, $substitutes) {
		foreach($substitutes as $var => $sub) {
			$content = preg_replace('/\{(' .$var. ')\}\s*(.*)[\t\n\r]*\{\/\1\}/', $sub, $content);
		}
		return $content;
	}
}

?>
