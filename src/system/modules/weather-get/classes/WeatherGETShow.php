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

use Contao\Model;
use Contao\Config;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\Pagination;
use cnajjar\WeatherAPI;


/**
 * Namespace
 */
namespace cnajjar\WeatherGET;


/**
 * Class WeatherShow
 *
 * @copyright  Christian Najjar 2016
 * @author     Christian Najjar,  info@christian-najjar.de
 * @package    Devtools
 */
class WeatherGETShow extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_weatherget_show';




	protected function WriteIntoDatabase($weatherdata,$weatherID,$cityname=""){
		
		//Update lastupdate info 
		if($cityname==""){
			$set = array('lastupdate'=>time());
		}else{
			$set = array('lastupdate'=>time(),'cityname'=>$cityname);
		}
		$this->Database->prepare('UPDATE tl_weatherget_info %s WHERE id=?')->set($set)->execute($weatherID);


		//Remove old WeatherData
		$this->Database->prepare('DELETE FROM  tl_weatherget_cache WHERE wid=?')->execute($weatherID);

		


		for($i=0; $i<count($weatherdata); $i++){

			$checkisset=array('daytime',"sunrise","sunset","temp","mintemp","maxtemp","nighttemp","evetemp","morntemp","pressure","humidity","weather_id","weather_desc","weather_icon","speed","deg","clouds");			

			$dayweather = $weatherdata[$i];

			foreach($checkisset as $check){
				if(!isset($dayweather[$check])){
					$dayweather[$check]='n/a';
				}
			}

			$set = array(
				'tstamp' 	=> time(), 
				'wid' 		=> htmlspecialchars ($weatherID), 
				'daytime'	=> htmlspecialchars ($dayweather['daytime']), 
				'sunrise'   => htmlspecialchars ($dayweather['sunrise']), 
				'sunset'    => htmlspecialchars ($dayweather['sunset']), 

				'temp'      => htmlspecialchars ($dayweather['temp']), 
				'mintemp'   => htmlspecialchars ($dayweather['mintemp']),  
				'maxtemp'   => htmlspecialchars ($dayweather['maxtemp']), 
				'nighttemp' => htmlspecialchars ($dayweather['nighttemp']), 
				'evetemp'   => htmlspecialchars ($dayweather['evetemp']),  
				'morntemp'  => htmlspecialchars ($dayweather['morntemp']), 

				'pressure'	=> htmlspecialchars ($dayweather['pressure']), 
				'humidity'  => htmlspecialchars ($dayweather['humidity']), 

				'weather_id'   => htmlspecialchars ($dayweather['weather_id']), 
				'weather_desc' => htmlspecialchars ($dayweather['weather_desc']), 
				'weather_icon' => htmlspecialchars ($dayweather['weather_icon']), 

				'speed' 	   => htmlspecialchars ($dayweather['speed']), 
				'deg' 	   	   => htmlspecialchars ($dayweather['deg']), 
				'clouds' 	   => htmlspecialchars ($dayweather['clouds'])	
			);

			$AddWeatherDay= $this->Database->prepare('INSERT INTO tl_weatherget_cache %s')->set($set)->execute();

		}


	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{

        if (TL_MODE == 'BE') {
            $this->BeOutput();
        } else {
            $this->FeOutput();
        }
   }


   private function BeOutput(){
   		$this->strTemplate          = 'be_wildcard';
        $this->Template             = new \BackendTemplate($this->strTemplate);
        //Load List on Weathermodule from Database
        $ListWeatherModules = $this->Database->prepare('SELECT * FROM tl_weatherget_info  WHERE id=? ')->execute($this->WeatherGETid);
        $rows = array();

        while($ListWeatherModules->next()){
            $rows[] = $ListWeatherModules->row();
        }

        $this->Template->title      = $rows[0]['title'];
      
        $this->Template->wildcard   = "### WETTER MODUL Nr. : ".$this->WeatherGETid." ###";
   }


   private function FeOutput(){
   		global $objPage;

        $strResults = '';

        //Load List on Weathermodule from Database
        $ListWeatherModules = $this->Database->prepare('SELECT * FROM tl_weatherget_info  WHERE id=? ')->execute($this->WeatherGETid);
        $rows = array();

        while($ListWeatherModules->next()){
            $rows[] = $ListWeatherModules->row();
        }


        if($rows[0]['customTpl']==""){
        	$wgTemplate = "mod_wg_".$rows[0]['platform'];
        }else{
        	$wgTemplate = $rows[0]['customTpl'];
        }

        $objTemplate = new \Contao\FrontendTemplate($wgTemplate);


        if(((time() - $rows[0]['lastupdate']) > (max(1,$rows[0]['toupdate']*3600)))||($rows[0]['lastupdate']==0)||(date('d',time())!=date('d',$rows[0]['lastupdate']))) {

	        $weatherfetch = new \cnajjar\WeatherAPI($rows[0]['apikey'], $rows[0]['cityid'] , $rows[0]['platform'], $rows[0]['idtype'], $rows[0]['Language'],$rows[0]['weathertype'],$rows[0]['units'],$rows[0]['showdays']);

	        $weatherdata = $weatherfetch->fetchWeatherData();
	        $cityname = $weatherfetch->fetchCityName();
	        //echo"<pre>";var_dump($weatherdata );die;
	        $this->WriteIntoDatabase($weatherdata,$this->WeatherGETid,$cityname);
	        $rows[0]['cityname']=$cityname;
        }


		//General Weather Info added to template
		$objTemplate->title = $rows[0]['title'];
  		$objTemplate->cityid = $rows[0]['cityid'];
  		$objTemplate->cityname = $rows[0]['cityname'];
  		$objTemplate->unit = $rows[0]['units'];
  		$objTemplate->wgTemplate = $wgTemplate;

  		// Load Weatherdata From Database
        $ListWeatherDays = $this->Database->prepare('SELECT * FROM tl_weatherget_cache  WHERE wid=? ORDER BY daytime ASC')->execute($this->WeatherGETid);
        $dayweather = array();
        $i=0;

        if($rows[0]['showdays']>0){
        	$limit = $rows[0]['showdays'];
        }else{
        	$limit =1;
        }

        while(($ListWeatherDays->next()) && ($i<$limit)){
            $dayweather[] = $ListWeatherDays->row();
            $i++; 
        }


        $objTemplate->weatherinfo = $dayweather;

        $strResults .= $objTemplate->parse();

        //Parse Template
        $this->Template->results = $strResults;


	}
}
