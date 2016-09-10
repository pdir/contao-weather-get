<?php

class Logger extends System
{
	public function __construct()
	{
		parent::__construct();
	}

	public function run()
	{
		$this->log(
			'weather-get was installed!',
			'Logger run()',
			'INFO'
		);
	}
}

$logger = new Logger();
$logger->run();
