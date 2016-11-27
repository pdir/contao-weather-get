<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package   WeatherGET
 * @author    Christian Najjar,  info@christian-najjar.de
 * @license   MIT
 * @copyright Christian Najjar 2016
 */


/**
 * Namespace
 */
namespace cnajjar;

use cnajjar\WeatherAPI\YahooWeatherAPI;
use cnajjar\WeatherAPI\OpenWeatherAPI;
use cnajjar\WeatherAPI\ForecastIOWeatherAPI;
use cnajjar\WeatherAPI\darkskyWeatherAPI;

/**
 * Class WeatherAPI
 *
 * @copyright  Christian Najjar 2016
 * @author     Christian Najjar,  info@christian-najjar.de
 * @package    Devtools
 */

class WeatherAPI
{
	protected $platform;

	protected $apikey;
	protected $place;
	protected $weathertype;
	protected $language;
	protected $idType;
	protected $unit;
	protected $maxdays;
	protected $cityname;

	public function  __construct($key="", $place ="", $platform="yahoo", $type="Unique", $language="de",$weathertype="forecast",$unit="metric",$maxdays=7){
		$this->apikey		=	$key;
		$this->place 		=	$place;
		$this->platform 	=	$platform;
		$this->weathertype	=	$weathertype;
		$this->language     =	$language;
		$this->idType       =   $type;
		$this->unit 		=   $unit;
		$this->maxdays		=	$maxdays;
	}

	public function fetchWeatherData(){

		switch ($this->platform){
        	case 'openweather':
        		$openweather = new \cnajjar\WeatherAPI\OpenWeatherAPI($this->apikey,$this->place,$this->language, $this->idType, $this->unit, $this->weathertype, $this->maxdays);
        		$weatherdata = $openweather->FetchWeather();
        		$this->cityname = $openweather->FetchName();
        	break;

        	case 'yahoo':
        		$yahoo = new \cnajjar\WeatherAPI\YahooWeatherAPI($this->place,$this->language, $this->idType, $this->unit);
        		$weatherdata = $yahoo->FetchWeather();
        		$this->cityname = $yahoo->FetchName();
        	break;
        	case 'forecastio':
        		$forecast = new \cnajjar\WeatherAPI\ForecastIOWeatherAPI($this->apikey,$this->place,$this->language, $this->unit);
        		$weatherdata = $forecast->FetchWeather();
        		$this->cityname = $forecast->FetchName();
        	break;
        	case 'darksky':
        		
        		$forecast = new \cnajjar\WeatherAPI\darkskyWeatherAPI($this->apikey,$this->place,$this->language, $this->unit);
        		$weatherdata = $forecast->FetchWeather();
        		$this->cityname = $forecast->FetchName();
        	break;
        }

        return $weatherdata;
	}
	public function fetchCityName(){
		return $this->cityname;
	}


}