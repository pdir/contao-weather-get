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
class WeatherGETShow extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_weatherget_show';


	/**
	 * Generate the module
	 */
	protected function compile(){
        if (TL_MODE == 'BE') {
            $this->BeOutput();
        } else {
            $this->FeOutput();
        }
    }


    private function BeOutput(){
   		$this->strTemplate          = 'be_wildcard';
        $this->Template             = new \BackendTemplate($this->strTemplate);
        
        //Using Model and Contao find ROW as Object using id
        $objWeather = \WeatherModel::findById($this->WeatherGETid);

        //Set Wildcard Template Data
        $this->Template->title      = $objWeather->title;
        $this->Template->wildcard   = "### WETTER MODUL Nr. : ".$objWeather->id." ###";
    }


    private function FeOutput(){
        //Forming the Data "Outsourced" to WeatherGETFormOuput so it can be used for inserttags without using unnessacery resources.
        $output = new \WeatherGETFormOutput();
        $this->Template->results = $output->getrenderdweather($this->WeatherGETid);
	}

}
