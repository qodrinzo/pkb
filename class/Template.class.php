<?php

namespace PKB;

use \Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface;

class Template extends PhpRenderer {
	protected $vars = array();

	public function __set ( $name, $value ) {
		$this->vars[$name] = $value;
	}

	public function &__get ( $name ) {
		return $this->vars[$name];
	}

	public function render(ResponseInterface $response, $template, array $data = []) {
		page_title();
		parent::render($response, $template, $data);
	}
}
