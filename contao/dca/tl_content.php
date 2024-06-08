<?php

use Pdir\ContaoWeatherGetBundle\Controller\ContentElement\WeatherGetElementController;

$GLOBALS['TL_DCA']['tl_content']['palettes'][WeatherGetElementController::TYPE] = '{title_legend},name,type;{weather_legend},WeatherGETid;{expert_legend:hide}guests,cssID,space;';

$GLOBALS['TL_DCA']['tl_content']['fields']['WeatherGETid'] = array(
         'label' => &$GLOBALS['TL_LANG']['MOD']['WeatherGETid'],
         'inputType' => 'select',
         'eval' => array(
            'mandatory' => true,
            'tl_class' => 'w50'),
         'sql' => "int(10) unsigned NOT NULL default '0'"
);
