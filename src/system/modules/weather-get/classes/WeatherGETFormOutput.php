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
class WeatherGETFormOutput extends \Frontend
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_weatherget_show';

	protected function WriteIntoDatabase($weatherdata,$weatherID,$cityname=""){
        $weatherdata = \Input::cleanKey($weatherdata);  
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
				'wid' 		=> $weatherID, 
				'daytime'	=> $dayweather['daytime'], 
				'sunrise'   => $dayweather['sunrise'], 
				'sunset'    => $dayweather['sunset'], 

				'temp'      => $dayweather['temp'], 
				'mintemp'   => $dayweather['mintemp'],  
				'maxtemp'   => $dayweather['maxtemp'], 
				'nighttemp' => $dayweather['nighttemp'], 
				'evetemp'   => $dayweather['evetemp'],  
				'morntemp'  => $dayweather['morntemp'], 

				'pressure'	=> $dayweather['pressure'], 
				'humidity'  => $dayweather['humidity'], 

				'weather_id'   => $dayweather['weather_id'], 
				'weather_desc' => $dayweather['weather_desc'], 
				'weather_icon' => $dayweather['weather_icon'], 

				'speed' 	   => $dayweather['speed'], 
				'deg' 	   	   => $dayweather['deg'], 
				'clouds' 	   => $dayweather['clouds']	
			);

			$AddWeatherDay= $this->Database->prepare('INSERT INTO tl_weatherget_cache %s')->set($set)->execute();

		}


	}


    private  function formoutput($weatherid){

        $strResults = '';

        $objWeather = \WeatherModel::findById($weatherid);
 
        if($objWeather->customTpl==""){
            $wgTemplate = "mod_wg_".$objWeather->platform;
        }else{
            $wgTemplate = $objWeather->customTpl;
        }

        $objTemplate = new \Contao\FrontendTemplate($wgTemplate);


        if(((time() - $objWeather->lastupdate) > (max(1,$objWeather->toupdate*3600)))||($objWeather->lastupdate==0)||(date('d',time())!=date('d',$objWeather->lastupdate))) {

            $weatherfetch = new \cnajjar\WeatherAPI($objWeather->apikey, 
                                                    $objWeather->cityid ,
                                                    $objWeather->platform, 
                                                    $objWeather->idtype, 
                                                    $objWeather->Language,
                                                    $objWeather->weathertype,
                                                    $objWeather->units,
                                                    $objWeather->showdays);

            $weatherdata = $weatherfetch->fetchWeatherData();
            $cityname = $weatherfetch->fetchCityName();
            //echo"<pre>";var_dump($weatherdata );die;
            $this->WriteIntoDatabase($weatherdata,$weatherid,$cityname);
            $objWeather->cityname=$cityname;
        }


        //General Weather Info added to template
        $objTemplate->title = $objWeather->title;
        $objTemplate->cityid = $objWeather->cityid;
        $objTemplate->cityname = $objWeather->cityname;
        $objTemplate->unit = $objWeather->units;
        $objTemplate->wgTemplate = $wgTemplate;

        // Load Weatherdata From Database
        $ListWeatherDays = $this->Database->prepare('SELECT * FROM tl_weatherget_cache  WHERE wid=? ORDER BY daytime ASC')->execute($weatherid);
        $dayweather = array();
        $i=0;

        if($objWeather->showdays>0){
            $limit = $objWeather->showdays;
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
        return  $strResults;
    }


    public function getrenderdweather($weatherid){
       return $this->formoutput($weatherid);
    }	
}
