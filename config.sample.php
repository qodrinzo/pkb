<?php

namespace PKB;

class Config {
	static $dev_mode = true;
	static $local    = true;

	public $site = [
		'title'	=> 'PKB',
		'title_long' => 'Personal Knowledge Base',
		'root'	=> 'http://localhost/pkb/',
	];

	public $doctypes = [
		'sys',
		'know',
		'notebook',
		'tag',
	];

	public $restricted = '#[\\/|?<>*:"]#';
}

?>
