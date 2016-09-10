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
namespace cnajjar\WeatherAPI;


/**
 * Class WeatherAPI\YahooWeatherAPI
 *
 * @copyright  Christian Najjar 2016
 * @author     Christian Najjar,  info@christian-najjar.de
 * @package    Devtools
 */

class YahooWeatherAPI
{
	protected $place;
	protected $language;
	protected $idType;
	protected $unit;
	protected $cityname="";


	public function  __construct($place ="", $language="de", $type="Unique", $unit="metric"){
		
		$this->place 		=	$place;
		$this->language     =	$language;
		$this->idType       =   $type;
		$this->unit 		=   $unit;
	}
	protected function setWeathericon($condid) {
	  $icon = '';
	      switch($condid) {
	        case '0': $icon  = 'wi-tornado';
	          break;
	        case '1': $icon = 'wi-storm-showers';
	          break;
	        case '2': $icon = 'wi-tornado';
	          break;
	        case '3': $icon = 'wi-thunderstorm';
	          break;
	        case '4': $icon = 'wi-thunderstorm';
	          break;
	        case '5': $icon = 'wi-snow';
	          break;
	        case '6': $icon = 'wi-rain-mix';
	          break;
	        case '7': $icon = 'wi-rain-mix';
	          break;
	        case '8': $icon = 'wi-sprinkle';
	          break;
	        case '9': $icon = 'wi-sprinkle';
	          break;
	        case '10': $icon = 'wi-hail';
	          break;
	        case '11': $icon = 'wi-showers';
	          break;
	        case '12': $icon = 'wi-showers';
	          break;
	        case '13': $icon = 'wi-snow';
	          break;
	        case '14': $icon = 'wi-storm-showers';
	          break;
	        case '15': $icon = 'wi-snow';
	          break;
	        case '16': $icon = 'wi-snow';
	          break;
	        case '17': $icon = 'wi-hail';
	          break;
	        case '18': $icon = 'wi-hail';
	          break;
	        case '19': $icon = 'wi-cloudy-gusts';
	          break;
	        case '20': $icon = 'wi-fog';
	          break;
	        case '21': $icon = 'wi-fog';
	          break;
	        case '22': $icon = 'wi-fog';
	          break;
	        case '23': $icon = 'wi-cloudy-gusts';
	          break;
	        case '24': $icon = 'wi-cloudy-windy';
	          break;
	        case '25': $icon = 'wi-thermometer';
	          break;
	        case '26': $icon = 'wi-cloudy';
	          break;
	        case '27': $icon = 'wi-night-cloudy';
	          break;
	        case '28': $icon = 'wi-day-cloudy';
	          break;
	        case '29': $icon = 'wi-night-cloudy';
	          break;
	        case '30': $icon = 'wi-day-cloudy';
	          break;
	        case '31': $icon = 'wi-night-clear';
	          break;
	        case '32': $icon = 'wi-day-sunny';
	          break;
	        case '33': $icon = 'wi-night-clear';
	          break;
	        case '34': $icon = 'wi-day-sunny-overcast';
	          break;
	        case '35': $icon = 'wi-hail';
	          break;
	        case '36': $icon = 'wi-day-sunny';
	          break;
	        case '37': $icon = 'wi-thunderstorm';
	          break;
	        case '38': $icon = 'wi-thunderstorm';
	          break;
	        case '39': $icon = 'wi-thunderstorm';
	          break;
	        case '40': $icon = 'wi-storm-showers';
	          break;
	        case '41': $icon = 'wi-snow';
	          break;
	        case '42': $icon = 'wi-snow';
	          break;
	        case '43': $icon = 'wi-snow';
	          break;
	        case '44': $icon = 'wi-cloudy';
	          break;
	        case '45': $icon = 'wi-lightning';
	          break;
	        case '46': $icon = 'wi-snow';
	          break;
	        case '47': $icon = 'wi-thunderstorm';
	          break;
	        case '3200': $icon = 'wi-cloud';
	          break;
	        default: $icon = 'wi-cloud';
	          break;
	      }
	  
	      return $icon;
	}
	protected function BuildURL(){
		//BASE URL for yahoo query language;
		$BASE_URL = "http://query.yahooapis.com/v1/public/yql";
		//Base to find weather
    	$yql_query = 'select * from weather.forecast where woeid in ';

		switch ($this->idType){
			case 'Unique':
				//Absolute uniuqe identifier = yahoo woeid
				$yql_query .= utf8_encode($this->place);
			break;
			case 'Name':
				//Try to Find City With Name
				$yql_query .='(select woeid from geo.places(1) where text="'.$this->place.'" )';
			break;
			case 'Coordinates':
				//lat / lon Coordinates
				$yql_query .='(select woeid from geo.places(1) where text="('.$this->place.')")';
			break;
		}

		//ADD Units to Query
		if($this->unit=="metric"){
        	$unit = 'c';	
        }else{
        	$unit = 'f';
        }
        $yql_query .=' and u=\''.$unit.'\' ';

        //Build URL
		$url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json&u=".$unit;


		return $url;
	} 

	public function FetchWeather(){


		$url = $this->BuildURL();

		
		//GET Data From Yahoo using JSON
		$session = curl_init($url);
    	curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    	$json = curl_exec($session);
		$data=json_decode($json,true);
		if(isset($data["query"]["results"])){
			$weather = $data["query"]["results"]["channel"];
		
			$dayweather = $weather["item"];

			if(($this->language=="de")){
				include_once(__DIR__."/langcodes/de.php");
				$text = $yahoo->codes[$dayweather['condition']['code']];
			}else{
				$text = $dayweather['condition']['text'];
			}
			$this->cityname = $weather["location"]["city"];

			$weatherData[] = array(
				'tstamp' 	=> time(), 
				'daytime'	=> strtotime($dayweather['condition']['date']),
				'sunrise'   => $weather["astronomy"]["sunrise"],
				'sunset'    => $weather["astronomy"]["sunset"],

				'temp'      => $dayweather['condition']['temp'],
				'mintemp'   => $weather["item"]['forecast'][0]['low'], 
				'maxtemp'   => $weather["item"]['forecast'][0]['high'],
		
				'pressure'	=> $weather["atmosphere"]["pressure"],
				'humidity'  => $weather["atmosphere"]["humidity"],

				'weather_id'   => $dayweather['condition']['code'],
				'weather_desc' => $text,
				'weather_icon' => $this->setWeathericon($dayweather['condition']['code']),
	 
				'speed' 	   => $weather["wind"]["speed"],
				'deg' 	   	   => $weather["wind"]["direction"],
				'clouds' 	   => $weather["atmosphere"]["visibility"]
			);


			//Insert New WeatherData Forecast begin day 2
			for($i=1; $i<count($weather["item"]['forecast']); $i++){
				$dayweather = $weather["item"]['forecast'][$i];

				if(($this->language=="de")){
					 include_once(__DIR__."/langcodes/de.php");
					$text = $yahoo->codes[$dayweather['code']];
				}else{
					$text = $dayweather['text'];
				}

				$weatherData[]  = array(
					'tstamp' 	=> time(), 
					'daytime'	=> strtotime($dayweather['date']),

					'temp'   => $dayweather['high'],
					'mintemp'   => $dayweather['low'], 
					'maxtemp'   => $dayweather['high'],

					'weather_id'   => $dayweather['code'],
					'weather_desc' => $text,
					'weather_icon' => $this->setWeathericon($dayweather['code']),
				);
			}
		}
		if(empty($weatherData)){
			$weatherData[]=array(
						'tstamp' 	=> time(), 
						'daytime'	=> 'error',
						'sunrise'   => 'error',
						'sunset'    => 'error',

						'temp'   	=> 'error',
						'mintemp'   => 'error',
						'maxtemp'   => 'error',
						

						'pressure'	=> 'error',
						'humidity'  => 'error',

						'weather_id'   => 'error',
						'weather_desc' => 'error',
						'weather_icon' => 'error',

						'speed' 	   => 'error',
						'deg' 	   	   => 'error',
						'clouds' 	   => 'error'	
			);
			$this->cityname ="error";
		}

		return $weatherData;
	}

	public function FetchName(){
		return $this->cityname;
	}

}