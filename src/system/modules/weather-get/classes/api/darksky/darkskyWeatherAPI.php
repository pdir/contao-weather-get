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

class darkskyWeatherAPI
{
    protected $place;
	protected $language;
	protected $unit;
	protected $apikey;

	protected $cityname="";

	public function  __construct($key,$place ="", $language="de",  $unit="metric"){
		$this->apikey		=   $key;
		$this->place 		=	$place;
		$this->language     =	$language;

		$this->unit 		=   $unit;

	}

	protected function BuildURL(){

		$unit="us";
		if($this->unit=="metric"){
			$unit="ca";
		}
		 
		$coordinates = str_replace(' ', '', $this->place );

		if(preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $coordinates )){
		$url= 'https://api.darksky.net/forecast/'.$this->apikey.'/'.$coordinates.'?lang='.$this->language.'&units='.$unit.'&exclude=hourly';
		}else{
			$url="error";
		}
		
		return $url;
		
	} 

	public function FetchWeather(){


		$url = $this->BuildURL();
		if($url!="error"){
    		$json = file_get_contents($url);
			$data=json_decode($json,true);
		}
		//echo"<pre>";var_dump($data);die;
		$weatherData=array();
	
		if(isset($data['daily'])){
			$this->cityname=$data['latitude'].','.$data['longitude'];
			$weatherData[] =array(	
				'tstamp' 	=> time(), 
				'daytime'	=> $data['currently']['time'],
				'sunrise'   => $data['daily']['data'][0]['sunriseTime'],
				'sunset'   =>  $data['daily']['data'][0]['sunsetTime'],

				'temp'   => $data['currently']['temperature'],
				'mintemp'   => $data['daily']['data'][0]['temperatureMin'], 
				'maxtemp'   => $data['daily']['data'][0]['temperatureMax'],

				'pressure'	=> $data['currently']['pressure'],
				'humidity'  => $data['currently']['humidity'],
				'weather_desc' => $data['currently']['summary'],
				'weather_icon' => $data['currently']['icon'],

				'speed' 	   => $data['currently']['windSpeed'],
				'deg' 	   	   => $data['currently']['windBearing'],
				'clouds' 	   => $data['currently']['cloudCover'],
			);			

			for($i=1;$i<count($data['daily']['data']);$i++){
				$dayweather = $data['daily']['data'][$i];
				$weatherData[] = array(
					'tstamp' 	=> time(), 
					'daytime'	=> $dayweather['time'],
					'sunrise'   => $dayweather['sunriseTime'],
					'sunset'   =>  $dayweather['sunsetTime'],

					'temp'      => $dayweather['temperatureMax'],
					'mintemp'   => $dayweather['temperatureMin'], 
					'maxtemp'   => $dayweather['temperatureMax'],


					'pressure'	=> $dayweather['pressure'],
					'humidity'  => $dayweather['humidity'],

					'weather_desc' => $dayweather['summary'],
					'weather_icon' => $dayweather['icon'],

					'speed' 	   => $dayweather['windSpeed'],
					'deg' 	   	   => $dayweather['windBearing'],
					'clouds' 	   => $dayweather['cloudCover'],
					'rain'		   => $dayweather['precipIntensity']	
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