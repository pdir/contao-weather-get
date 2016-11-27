<?php

class changePlatformDarkSky extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function run()
	{
        if ($this->Database->tableExists('tl_weatherget_info'))
        {
        	$set = array('platform'=>'darksky');
		

			$this->Database->prepare('UPDATE tl_weatherget_info %s WHERE platform=?')->set($set)->execute('forecastio');
        }
	}
}


$objchangeForecastToDarkSky = new changePlatformDarkSky();
$objchangeForecastToDarkSky->run();