<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'cnajjar',
	'cnajjar\WeatherGET',
	'cnajjar\WeatherAPI',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'cnajjar\WeatherAPI'   				   		=> 'system/modules/weather-get/classes/api/WeatherAPI.php',
	'cnajjar\WeatherAPI\YahooWeatherAPI'   		=> 'system/modules/weather-get/classes/api/yahoo/YahooWeatherAPI.php',
	'cnajjar\WeatherAPI\OpenWeatherAPI'    		=> 'system/modules/weather-get/classes/api/openweather/OpenWeatherAPI.php',
	'cnajjar\WeatherAPI\ForecastIOWeatherAPI'   => 'system/modules/weather-get/classes/api/forecastio/ForecastIOWeatherAPI.php',
	'cnajjar\WeatherAPI\darkskyWeatherAPI'   	=> 'system/modules/weather-get/classes/api/darksky/darkskyWeatherAPI.php',


	'cnajjar\WeatherGET\WeatherGETInfo'   		=> 'system/modules/weather-get/classes/WeatherGETInfo.php',
	'cnajjar\WeatherGET\WeatherGETModule' 		=> 'system/modules/weather-get/classes/WeatherGETModule.php',
	'cnajjar\WeatherGET\WeatherGETShow'   		=> 'system/modules/weather-get/classes/WeatherGETShow.php',
	'cnajjar\WeatherGET\WeatherGETInsert' 		=> 'system/modules/weather-get/classes/WeatherGETInsert.php',
	'cnajjar\WeatherGET\WeatherGETFormOutput' 	=> 'system/modules/weather-get/classes/WeatherGETFormOutput.php',
	'cnajjar\WeatherGET\WeatherModel' 	  		=> 'system/modules/weather-get/models/WeatherModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_weatherget_show' => 'system/modules/weather-get/templates',
	'mod_wg_yahoo'        => 'system/modules/weather-get/templates',
	'mod_wg_openweather'  => 'system/modules/weather-get/templates',
	'mod_wg_forecastio'   => 'system/modules/weather-get/templates',
	'mod_wg_darksky'   	  => 'system/modules/weather-get/templates'
));
